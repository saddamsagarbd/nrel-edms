$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function printErrorMsg(msg) {
    toastr.options = {
        "closeButton": true,
        "newestOnTop": true,
        "positionClass": "toast-top-right"
    };
    var error_html = '';
    for (var count = 0; count < msg.length; count++) {
        error_html += '<p>' + msg[count] + '</p>';
    }
    toastr.error(error_html);
}
function printSuccessMsg(msg) {
    toastr.options = {
        "closeButton": true,
        "newestOnTop": true,
        "positionClass": "toast-top-right"
    };
    toastr.success(msg);
}
function uuidv4() {
    return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
        var r = Math.random() * 16 | 0, v = c == 'x' ? r : (r & 0x3 | 0x8);
        return v.toString(16);
    });
}

$(document).on('click', '.modal', function (e) {
    if ($(e.target).hasClass('modal')) {
        e.stopPropagation();  // Prevent closing the modal if clicking on it
    }
});

// $('#myModal').on('mousedown', function (e) {
$(document).on('mousedown', '.modal', function (e) {
    console.log("drag");
    e.stopPropagation();
});
$(document).on('hide.bs.modal', '.modal', function (e) {
    if ($(document).find('.select2-container--open').length) {
        e.preventDefault();  // Prevent the modal from closing if the Select2 dropdown is open
    }
});

// $("#resetCriteria").hide();

$(document).on("click", "#resetCriteria", function(){
    $("#searchCriteria").trigger("reset");
    location.reload();
});

var colors = {
    primary        : "#6571ff",
    secondary      : "#7987a1",
    success        : "#05a34a",
    info           : "#66d1d1",
    warning        : "#fbbc06",
    danger         : "#ff3366",
    light          : "#e9ecef",
    dark           : "#060c17",
    muted          : "#7987a1",
    gridBorder     : "rgba(77, 138, 240, .15)",
    bodyColor      : "#000",
    cardBg         : "#fff"
}

var fontFamily = "'Roboto', Helvetica, sans-serif"

if($('#monthlyEntryChart').length) {
    var options = {
    chart: {
        type: 'bar',
        height: '318',
        parentHeightOffset: 0,
        foreColor: colors.bodyColor,
        background: colors.cardBg,
        toolbar: {
        show: false
        },
    },
    theme: {
        mode: 'light'
    },
    tooltip: {
        theme: 'light'
    },
    colors: [colors.primary],  
    fill: {
        opacity: .9
    } , 
    grid: {
        padding: {
        bottom: -4
        },
        borderColor: colors.gridBorder,
        xaxis: {
        lines: {
            show: true
        }
        }
    },
    series: [{
        name: 'Entry',
        data: _daydata,
    }],
    xaxis: {
        type: 'datetime',
        categories: _daylabels,
        axisBorder: {
        color: colors.gridBorder,
        },
        axisTicks: {
        color: colors.gridBorder,
        },
    },
    yaxis: {
        title: {
        text: 'Number of Entry',
        style:{
            size: 9,
            color: colors.muted
        }
        },
    },
    legend: {
        show: true,
        position: "top",
        horizontalAlign: 'center',
        fontFamily: fontFamily,
        itemMargin: {
        horizontal: 8,
        vertical: 0
        },
    },
    stroke: {
        width: 0
    },
    dataLabels: {
        enabled: true,
        style: {
        fontSize: '10px',
        fontFamily: fontFamily,
        },
        offsetY: -27
    },
    plotOptions: {
        bar: {
        columnWidth: "50%",
        borderRadius: 4,
        dataLabels: {
            position: 'top',
            orientation: 'vertical',
        }
        },
    },
    }
    
    var apexBarChart = new ApexCharts(document.querySelector("#monthlyEntryChart"), options);
    apexBarChart.render();
}



