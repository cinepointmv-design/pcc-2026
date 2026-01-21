<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Students;
use App\Models\Batch;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache; // Import Cache

class MarkStudentsCompleted extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'students:mark-completed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically mark students as completed and free seats if their course duration is over';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // 1. Force a visible message for debugging
        $this->info("Cron Job Starting...");

        try {
            // Your existing logic...
            $students = Students::where(function($q) {
                $q->where('status', '!=', 'Completed')
                  ->where('status', '!=', 'Removed')
                  ->orWhereNull('status');
            })->with('studentCourses.course')->get();

            $count = 0;

            foreach ($students as $student) {
                if (!$student->joiningdate) continue;

                $totalDuration = 0;
                foreach ($student->studentCourses as $sc) {
                    if ($sc->course && isset($sc->course->duration)) {
                        $totalDuration += (int) $sc->course->duration;
                    }
                }

                $joinDate = Carbon::parse($student->joiningdate);
                // Using MINUTES logic
                $endDate = $joinDate->copy()->addMinutes($totalDuration); 

                if ($endDate->isPast()) {
                    $student->status = 'Completed';
                    $student->save();
                    
                    $processedBatches = []; 
                    foreach ($student->studentCourses as $sc) {
                        $batchId = $sc->batch;
                        if ($batchId && !in_array($batchId, $processedBatches)) {
                            Batch::where('id', $batchId)->increment('pending_seats', 1);
                            $processedBatches[] = $batchId;
                        }
                    }
                    $count++;
                }
            }
            
            // --- NEW: SAVE TIME TO TEXT FILE (Bypass Cache) ---
            file_put_contents(public_path('last_check.txt'), now());
            
            $this->info("Success! Processed {$count} students. Time saved to file.");

        } catch (\Exception $e) {
            $this->error("Error: " . $e->getMessage());
        }
    }
}