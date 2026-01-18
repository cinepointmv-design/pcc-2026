$(document).ready(function () {

    // Sidebar Tooltip
    // $('.sidebar .nav-link').tooltip({
    //     placement: 'right', 
    //     title: function () {
    //         return $(this).find('.text').text();
    //     },
    //     trigger: 'hover', 
    //     template: '<div class="tooltip white-tooltip" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>' 
    // });

    // show sidebar
    $('.sidebar .accordion-collapse').addClass('show');
    $('.sidebar-close-btn').click(function () {
        $('.sidebar').toggleClass('hide');
        $('.main-content').toggleClass('sidebar-hide');
        $('.main-header').toggleClass('sidebar-hide');
        $('.accordion-collapse').toggleClass('d-block');
        $('.accordion-header').toggleClass('d-none');
    });

    // show sidebar mobile
    $(".sidebar-close-btn-mb").click(function () {
        $(".sidebar").addClass("sidebar-show-mb");
        $(".overlay-bg ").addClass("show");
    });

    $(".overlay-bg").click(function () {
        $(".sidebar").removeClass("sidebar-show-mb");
        $(".overlay-bg ").removeClass("show");
    });

    // Prevent the dropdown from closing
    $(document).ready(function () {
        $('.dropdown-menu li').click(function (e) {
            e.stopPropagation();
        });
    });

    // select all table checkbox
    $('#selectAll').change(function () {
        $('.data-table .select-checkbox').prop('checked', this.checked);
        if (this.checked) {
            $('.table-selection-col').show();
            $('#delete-dropdown').show();
        } else {
            $('.table-selection-col').hide();
            $('#delete-dropdown').hide();
        }
    });

    // select all service checkbox
    $('#allService').change(function () {
        $('.form-service-checkbox .service-check').prop('checked', this.checked);
    });


    // show table header
    function areAnyCheckboxesChecked() {
        return $('.data-table .select-checkbox:checked').length > 0;
    }
    $('.table-selection-col').hide();
    $('#delete-dropdown').hide();

    $('.data-table .select-checkbox').on('change', function () {
        if (areAnyCheckboxesChecked()) {
            $('.table-selection-col').show();
            $('#delete-dropdown').show();
        } else {
            $('.table-selection-col').hide();
            $('#delete-dropdown').hide();
        }
    });

    // copy username and pass

    $('.user-copy').click(function () {
        var userText = $('.user-show').text();
        var tempInput = $('<input>');
        $('body').append(tempInput);
        tempInput.val(userText).select();
        document.execCommand('copy');
        tempInput.remove();
        alert('Username copied: ' + userText);
    });

    $('.pass-copy').click(function () {
        var passText = $('.pass-show').text();
        var tempInput = $('<input>');
        $('body').append(tempInput);
        tempInput.val(passText).select();
        document.execCommand('copy');
        tempInput.remove();
        alert('Password copied: ' + passText);
    });


    // Monthly Revenue Chart

    var data = {
        labels: ["Jan 2023", "Feb 2023", "Mar 2023", "Apr 2023", "May 2023", "Jun 2023", "Jul 2023", "Aug 2023", "Sep 2023"],
        datasets: [{
            label: 'Revenue By Months',
            data: [0, 2273, 3158, 1768, 5237, 21689, 57036, 53364, 27880],
            backgroundColor: 'skyblue',
            borderColor: 'rgba(75, 192, 192, 0)',
            borderWidth: 0
        }]
    };

    var yAxesOptions = {
        type: 'linear',
        beginAtZero: false,
        scaleLabel: {
            display: true,
            labelString: 'Revenue',
            fontSize: 14
        },
        ticks: {
            fontSize: 12,
            callback: function (value, index, values) {
                if (value === 0) return '0';
                if (value === 2000) return '2000';
                if (value === 40000) return '40000';
                if (value === 60000) return '60000';
                return '';
            },
            maxTicksLimit: 4
        }
    };

    var options = {
        scales: {
            y: [yAxesOptions]
        }
    };

    var ctx = document.getElementById('monthly-revenue-chart').getContext('2d');
    var myBarChart = new Chart(ctx, {
        type: 'bar',
        data: data,
        options: options
    });

    // Daily Revenue Chart

    var data = {
        labels: ["Aug 20", "Aug 21", "Aug 22", "Aug 23", "Aug 24", "Aug 25", "Aug 26", "Aug 27", "Aug 28", "Aug 29", "Aug 30", "Aug 31", "Sep 01", "Sep 02", "Sep 03", "Sep 04", "Sep 05", "Sep 06", "Sep 07", "Sep 08", "Sep 09", "Sep 10", "Sep 11", "Sep 12", "Sep 13", "Sep 14", "Sep 15", "Sep 16", "Sep 17", "Sep 18", "Sep 19"],
        datasets: [{
            label: 'Revenue By Day in ($)',
            data: [1276, 2248, 2277, 2896, 2394, 2039, 2059, 2261, 1637, 972, 1000, 980, 2500, 550, 340, 1800, 340, 590, 2800, 1080, 550, 680, 2800, 1972, 220, 680, 1900, 386, 2200, 200, 2200], // Replace with your desired values
            backgroundColor: 'rgb(142,213,181)', // Change to the desired color
            borderColor: 'rgba(75, 192, 192, 0)',
            borderWidth: 0
        }]
    };

    var yAxesOptions = {
        type: 'linear',
        beginAtZero: false,
        scaleLabel: {
            display: true,
            labelString: 'Revenue',
            fontSize: 14
        },
        ticks: {
            fontSize: 12,
            callback: function (value, index, values) {
                if (value === 0) return '0';
                if (value === 1000) return '1000';
                if (value === 2000) return '2000';
                if (value === 3000) return '3000';
                return '';
            },
            maxTicksLimit: 4
        }
    };

    var options = {
        scales: {
            y: [yAxesOptions]
        }
    };

    var ctx = document.getElementById('daily-revenue-chart').getContext('2d');
    var myBarChart = new Chart(ctx, {
        type: 'bar',
        data: data,
        options: options
    });

    // Daily Free Chart

    var data = {
        labels: ["Aug 20", "Aug 21", "Aug 22", "Aug 23", "Aug 24", "Aug 25", "Aug 26", "Aug 27", "Aug 28", "Aug 29", "Aug 30", "Aug 31", "Sep 01", "Sep 02", "Sep 03", "Sep 04", "Sep 05", "Sep 06", "Sep 07", "Sep 08", "Sep 09", "Sep 10", "Sep 11", "Sep 12", "Sep 13", "Sep 14", "Sep 15", "Sep 16", "Sep 17", "Sep 18", "Sep 19"],
        datasets: [{
            label: 'Free Order Of Current Month)',
            data: [1276, 2248, 2277, 2896, 2394, 2039, 2059, 2261, 1637, 972, 1000, 980, 2500, 550, 340, 1800, 340, 590, 2800, 1080, 550, 680, 2800, 1972, 220, 680, 1900, 386, 2200, 200, 2200], // Replace with your desired values
            backgroundColor: 'rgb(142,213,181)', // Change to the desired color
            borderColor: 'rgba(75, 192, 192, 0)',
            borderWidth: 0
        }]
    };

    var yAxesOptions = {
        type: 'linear',
        beginAtZero: false,
        scaleLabel: {
            display: true,
            labelString: 'Revenue',
            fontSize: 14
        },
        ticks: {
            fontSize: 12,
            callback: function (value, index, values) {
                if (value === 0) return '0';
                if (value === 1000) return '1000';
                if (value === 2000) return '2000';
                if (value === 3000) return '3000';
                return '';
            },
            maxTicksLimit: 4
        }
    };

    var options = {
        scales: {
            y: [yAxesOptions]
        }
    };

    var ctx = document.getElementById('daily-free-chart').getContext('2d');
    var myBarChart = new Chart(ctx, {
        type: 'bar',
        data: data,
        options: options
    });





});


// trex editor

document.addEventListener("trix-initialize", function () {
    var editor = document.getElementById('editor');
    var trix = new Trix.Editor(editor);
});


// tinymce editor

tinymce.init({
    selector: '#additonal-des',
    plugins: 'advlist autolink lists link image charmap print preview anchor searchreplace visualblocks code fullscreen insertdatetime media table contextmenu paste help wordcount',
    toolbar: 'undo redo | formatselect fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media | forecolor backcolor emoticons | code',
});


function goback(){
        window.history.back();
}


    




