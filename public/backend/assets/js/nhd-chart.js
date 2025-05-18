$(function () {
    "use strict";

    const predefinedBgColors = ['rgb(255, 99, 132, 0.5)','rgb(54, 162, 235, 0.5)','rgb(255, 205, 86, 0.5)','rgb(75, 192, 192, 0.5)','rgb(153, 102, 255, 0.5)','rgb(255, 159, 64, 0.5)','rgb(255, 99, 71, 0.5)','rgb(32, 178, 170, 0.5)','rgb(135, 206, 250, 0.5)','rgb(255, 165, 0, 0.5)','rgb(0, 128, 0, 0.5)','rgb(128, 0, 128, 0.5)','rgb(255, 20, 147, 0.5)','rgb(255, 99, 71, 0.5)','rgb(173, 255, 47, 0.5)','rgb(139, 69, 19, 0.5)','rgb(60, 179, 113, 0.5)','rgb(0, 255, 255, 0.5)',
    ];
    
    const predefinedBorderColors = ['rgb(255, 99, 132)', 'rgb(54, 162, 235)', 'rgb(255, 205, 86)', 'rgb(75, 192, 192)', 'rgb(153, 102, 255)', 'rgb(255, 159, 64)', 'rgb(255, 99, 71)', 'rgb(32, 178, 170)', 'rgb(135, 206, 250)', 'rgb(255, 165, 0)', 'rgb(0, 128, 0)', 'rgb(128, 0, 128)', 'rgb(255, 20, 147)', 'rgb(255, 99, 71)', 'rgb(173, 255, 47)', 'rgb(139, 69, 19)', 'rgb(60, 179, 113)', 'rgb(0, 255, 255)'];

    // Function to get a subset of colors
    function getColorsForLabels(labels, colors) {
        return colors.slice(0, labels.length); // Adjust colors to match the number of labels
    }

    var company_names = chartData.company_names;
    var shortName = chartData.shortnameValues;
    var last7Days = chartData.last7Days;
    var requisition_count = chartData.requisition_count;

    // Get the appropriate number of background colors
    const backgroundColors = getColorsForLabels(company_names, predefinedBgColors);
    const borderColors = getColorsForLabels(company_names, predefinedBorderColors);

    const data = {
        labels: [
            'Approved',
            'Declined',
            'Pending'
        ],
        datasets: [{
            data: [chartData.totalApproved, chartData.totalRejected, chartData.totalProcessing],
            backgroundColor: [
                'rgb(54, 162, 235, 0.6)',
                'rgb(255, 99, 132, 0.6)',
                'rgb(255, 205, 86, 0.6)'
            ],
            borderColor: [
                'rgb(54, 162, 235)',
                'rgb(255, 99, 132)',
                'rgb(255, 205, 86)'
            ],
            hoverOffset: 4,
            borderWidth: 1
        }]
    };
    const config = {
        type: 'doughnut',
        data: data,
        options:{
            tooltip: {
                enabled: true,
                intersect: false,
                mode: 'nearest',
            },
            responsive: true,
            maintainAspectRatio: true,
            aspectRatio:2,
            plugins: {
                // colorschemes: {
                //     scheme: 'tableau.Tableau10' // Choose a predefined color scheme
                // },
                legend: {
                    display: false,
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Vehicle Requisition Status',
                    position: 'bottom',
                    font: {
                        size: 12,
                        weight: 'bold'
                    }
                },
                datalabels: {
                    color: '#fff',
                    formatter: function(value, context) {
                        // Display the company name along with the requisition count
                        return context.chart.data.labels[context.dataIndex] + ': ' + value;
                    },
                    font: {
                        weight: 'bold',
                        size: 12
                    },
                    align: 'center', // Align text to center
                    anchor: 'center', // Anchor the text in the center of the slice
                    clamp: true // Clamp text if it overflows
                }
            },
            interaction: {
                intersect: false, // Ensure tooltips show up even when not intersecting
                mode: 'nearest', // Show tooltips for all items in the same index
            }
        },
        plugins: [ChartDataLabels]
    };

    const dougnutChartVms = document.getElementById('dougnutChart').getContext('2d');    
    const dougnutChart = new Chart(dougnutChartVms, config);


    const sbuData = {
        labels: chartData.sbuLabels,
        datasets: [{
            label: 'SBU-wise Stationary Requisition Count',
            data: chartData.sbuValues,
            backgroundColor: getColorsForLabels(chartData.sbuLabels, predefinedBgColors),            
            borderColor: getColorsForLabels(chartData.sbuLabels, predefinedBorderColors),
            borderWidth: 1,
            hoverOffset: 4
        }]
    };

    const sbuConfig = {
        type: 'bar',
        data: sbuData,
        options:{
            indexAxis: 'y',
            tooltip: {
                enabled: true,
                intersect: false,
                mode: 'nearest',
            },
            responsive: true,
            maintainAspectRatio: true,
            aspectRatio:2,
            plugins: {
                // colorschemes: {
                //     scheme: 'tableau.Tableau10' // Choose a predefined color scheme
                // },
                legend: {
                    display: false,
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'SBU-wise Stationary Requisition Count',
                    position: 'bottom',
                    font: {
                        size: 12,
                        weight: 'bold'
                    }
                },
                datalabels: {
                    color: '#fff',
                    formatter: function(value, context) {
                        // Display the company name along with the requisition count
                        const label = context.chart.data.labels[context.dataIndex];
                        return value;
                    },
                    font: {
                        weight: 'bold',
                        size: 12
                    },
                    align: 'center', // Align text to center
                    anchor: 'center', // Anchor the text in the center of the slice
                    clamp: true // Clamp text if it overflows
                }
            },
            interaction: {
                intersect: false, // Ensure tooltips show up even when not intersecting
                mode: 'nearest', // Show tooltips for all items in the same index
            }
        },
        plugins: [ChartDataLabels]
    };
    const barChartElementSBU = document.getElementById('horizontalBarSBU').getContext('2d');
    const barChartSBU = new Chart(barChartElementSBU, sbuConfig);

    const vmsConcernwiseDougnutChart = document.getElementById('vmsConcernwiseDougnutChart').getContext('2d');

    new Chart(vmsConcernwiseDougnutChart, {
        type: 'bar',  // Change the type to 'bar'
        data: {
            labels: last7Days,  // Company short names on the X-axis
            datasets: [{
                label: 'Requisition Count',  // Label for the bar dataset
                data: requisition_count,  // Data for each company
                backgroundColor: backgroundColors,  // Dynamic bar colors
                borderColor: borderColors,  // Dynamic bar borders
                borderWidth: 1,  // Width of the border around each bar
                hoverOffset: 4  // Adds a slight offset on hover
            }]
        },
        options: {
            aspectRatio: 1.4,
            scales: {
                y: {
                    beginAtZero: true,  // Ensure the y-axis starts at zero
                    title: {
                        display: true,
                        text: 'Requisition Count'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Companies'
                    }
                }
            },
            plugins: {
                tooltip: {
                    enabled: true,
                    mode: 'nearest',
                    intersect: false,
                    callbacks: {
                        label: function(context) {
                            return `${context.dataset.label}: ${context.raw}`;
                        }
                    }
                },
                title: {
                    display: true,
                    text: 'Concern Wise Vehicle Requisition Over the Last 7 Days',
                    font: {
                        size: 12,
                        weight: 'bold'
                    }
                },
                datalabels: {
                    anchor: 'middle',  // Position the label at the end of each bar
                    align: 'top',   // Aligns the label to the top
                    formatter: function (value, context) {
                        const label = shortName[context.dataIndex] || '';
                        return `${label} - ${context.chart.data.datasets[0].data[context.dataIndex]}`;// Display value of the bar
                    },
                    color: 'black',  // Text color for the labels
                    font: {
                        weight: 'bold'
                    },
                    rotation: 270  // Rotates the label vertically (90 degrees)
                },
            },
            legend: {
                display: true,
                position: 'top'  // Position the legend at the top
            },
            responsive: true,
        },
    });
    
    const vmsBarChart = document.getElementById('vmsBarChart').getContext('2d');
    var location = chartData.axis;
    var labelitemty = chartData.shortnameValues;
    var dataitemty = chartData.traveler_no;

    // Function to wrap long labels
    const wrapLabel = (label, maxWidth) => {
        const words = label.split(' ');
        let line = '';
        const lines = [];
        const ctx = document.createElement('canvas').getContext('2d'); // Temporary canvas to measure text width
        ctx.font = '12px Arial'; // Use the font style used in your chart

        for (const word of words) {
            const testLine = line + word + ' ';
            const width = ctx.measureText(testLine).width;
            if (width > maxWidth && line.length > 0) {
                lines.push(line.trim());
                line = word + ' ';
            } else {
                line = testLine;
            }
        }
        lines.push(line.trim());
        return lines.join('\n');
    };
    
    const maxWidth = 200; // Maximum width in pixels for the label
    const wrappedLabels = location.map(label => wrapLabel(label, maxWidth));

    const barBackgroundColors = getColorsForLabels(labelitemty, predefinedBgColors);
    const barBorderColors = getColorsForLabels(labelitemty, predefinedBorderColors);


    new Chart(vmsBarChart, {
        type: 'line',
        data: {
            labels: labelitemty, // X-axis labels
            datasets: [{
                label: "Travelers",
                data: dataitemty, // Y-axis data
                fill: false,
                borderWidth: 1,
                borderColor: barBackgroundColors,
                backgroundColor: barBorderColors,
                tension: 0.4,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                // colorschemes: {
                //     scheme: 'brewer.Paired12'
                // },
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Today\'s Last 5 Vehicle Requisiton'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.dataset.label || '';
                            const value = context.raw;
                            const dataIndex = context.dataIndex;
                            const location = wrappedLabels[dataIndex];
                            return `${location}:${value}`;
                        }
                    }
                }
            },
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Route',
                        align: 'center',
                        font: {
                            size: 16,  // Increase font size
                            weight: 'bold'  // Make the text bold
                        }
                    }
                },
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'No. of Travelers',
                        align: 'center',
                        font: {
                            size: 16,  // Increase font size
                            weight: 'bold'  // Make the text bold
                        }
                    }
                }
            }
        },
    });

    const ticketComparisonBarChart = document.getElementById('ticketComparisonBarChart').getContext('2d');

    // Tooltip Labels
    var wrappedLabelsTkt = chartData.last7Days.map(function(date) {
        // Optionally format dates here if needed
        return date;
    });

    var ticketChartData = {
        labels: chartData.last7Days,
        datasets: [{
            label: "New",
            data: chartData.lastSevenDaysNewTickets,
            backgroundColor: 'rgba(31, 120, 180,0.6)', // Greenish color
            borderColor: 'rgba(31, 120, 180, 1)',
            borderWidth: 1
        }, {
            label: "Assigned",
            data: chartData.lastSevenDaysAssignedTickets,
            backgroundColor: 'rgba(178, 223, 138, 0.6)', // Purple color
            borderColor: 'rgba(178, 223, 138, 1)',
            borderWidth: 1
        }, {
            label: "Resolved",
            data: chartData.lastSevenDaysResolvedTickets,
            backgroundColor: 'rgba(166, 206, 227, 0.6)', // Orange color
            borderColor: 'rgba(166, 206, 227, 1)',
            borderWidth: 1
        }]
    };

    new Chart(ticketComparisonBarChart, {
        type: 'bar',
        data: ticketChartData,
        options: {
            responsive: true,
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Last 7 Days',
                        align: 'center',
                        font: {
                            size: 16,  // Increase font size
                            weight: 'bold'  // Make the text bold
                        }
                    }
                },
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Number of Tickets',
                        align: 'center',
                        font: {
                            size: 16,  // Increase font size
                            weight: 'bold'  // Make the text bold
                        }
                    }
                }
            },
            plugins: {
                tooltip: {
                    enabled: true,
                    mode: 'nearest',
                    intersect: false,
                    callbacks: {
                        label: function(context) {
                            return `${context.dataset.label}: ${context.raw}`;
                        }
                    }
                },
                legend: {
                    position: 'top',  // Places legend at the top of the chart
                },
                title: {
                    display: true,
                    text: 'Tickets Over the Last 7 Days'  // Chart title
                },
                datalabels: {
                    anchor: 'middle',  // Position the label at the end of each bar
                    align: 'top',   // Aligns the label to the top
                    formatter: function(value, context) {
                        const label = context.dataset.label || '';
                        const dataIndex = context.dataIndex;
                        const date = wrappedLabelsTkt[dataIndex];  // Get corresponding date for the data point
                        return `${label} - ${value}`;
                        // return value;  // Shows the value of the bar
                    },
                    color: 'black',  // Text color for the labels
                    font: {
                        weight: 'bold'
                    },
                    rotation: 270  // Rotates the label vertically (90 degrees)
                }
            },
        },
    });

    // Monthly ticket chart
    const monthlyTicketComparisonBarChart = document.getElementById('monthlyTicketComparisonBarChart').getContext('2d');

    // Tooltip Labels
    var wrappedLabelsTkt = chartData.monthDays.map(function(month) {
        // Optionally format dates here if needed
        return month;
    });

    var ticketMnthChartData = {
        labels: chartData.monthDays,
        datasets: [
        {
            label: "New",
            data: chartData.monthly_new_tkt_count,
            backgroundColor: 'rgba(220, 182, 77, 0.6)',
            borderColor: 'rgba(220, 182, 77, 1)',
            borderWidth: 1,
        },
        {
            label: "Assigned",
            data: chartData.monthly_assigned_tkt_count,
            backgroundColor: 'rgba(229, 151, 102, 0.6)',
            borderColor: 'rgba(229, 151, 102, 1)',
            borderWidth: 1,
        },
        {
            label: "Resolved",
            data: chartData.monthly_resolved_tkt_count,
            backgroundColor: 'rgba(63, 157, 181, 0.6)',
            borderColor: 'rgba(63, 157, 181, 1)',
            borderWidth: 1,
        }]
    };

    new Chart(monthlyTicketComparisonBarChart, {
        type: 'bar',
        data: ticketMnthChartData,
        options: {
            responsive: true,
            aspectRatio: 1.4,
            scales: {                
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Number of Tickets',
                        align: 'center',
                        font: {
                            size: 16,  // Increase font size
                            weight: 'bold'  // Make the text bold
                        }
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Name of the Months',
                        align: 'center',
                        font: {
                            size: 16,  // Increase font size
                            weight: 'bold'  // Make the text bold
                        }
                    }
                },
            },
            plugins: {
                tooltip: {
                    enabled: true,
                    mode: 'nearest',
                    intersect: false,
                    callbacks: {
                        label: function(context) {
                            return `${context.dataset.label}: ${context.raw}`;
                        }
                    }
                },
                legend: {
                    position: 'top',  // Places legend at the top of the chart
                },
                title: {
                    display: true,
                    text: 'Tickets Over the Last few Months'  // Chart title
                },
                datalabels: {
                    anchor: 'middle',  // Position the label at the end of each bar
                    align: 'top',   // Aligns the label to the top
                    // offset: 4, // Increase the offset to avoid overlap
                    // display: true, // Show/hide data labels
                    formatter: function(value, context) {
                        const label = context.dataset.label || '';
                        const dataIndex = context.dataIndex;
                        const month = wrappedLabelsTkt[dataIndex];  // Get corresponding date for the data point
                        return `${label}: ${value}`;
                    },
                    color: 'black',  // Text color for the labels
                    font: {
                        weight: 'bold'
                    },
                    rotation: 270  // No rotation for better readability
                }
            },
        },
    });

    // area chart ticket ratio by admin & ic&t

    var ctx = document.getElementById('mixedChart').getContext('2d');

    // Create gradient for IC&T
    var gradientAdmin = ctx.createLinearGradient(0, 0, 0, 400); // Adjust gradient direction
    gradientAdmin.addColorStop(0, 'rgba(0, 143, 251, 0.8)'); // Start color
    gradientAdmin.addColorStop(1, 'rgba(0, 143, 251, 0.2)'); // End color

    // Create gradient for Admin
    var gradientICT = ctx.createLinearGradient(0, 0, 0, 400); // Adjust gradient direction
    gradientICT.addColorStop(0, 'rgba(0, 227, 150, 0.8)'); // Start color
    gradientICT.addColorStop(1, 'rgba(0, 227, 150, 0.2)'); // End color

    const mixedChart = new Chart(document.getElementById('mixedChart').getContext('2d'), {
        type: 'line',
        data: {
            labels: chartData.getTktMonths,
            datasets: [
                {
                    label: 'IC&T',
                    data: chartData.groupedTickets[1],
                    borderColor: 'rgba(0, 227, 150, 1)',
                    backgroundColor: gradientICT,
                    fill: 'origin', // Fill under the line chart
                    tension: 0.4,
                    pointRadius: 6,
                    pointHoverRadius: 10,
                    pointStyle: 'circle',
                },
                {
                    label: 'Admin',
                    data: chartData.groupedTickets[2],
                    borderColor: 'rgba(0, 143, 251, 1)',
                    backgroundColor: gradientAdmin,
                    fill: 'origin', // Fill under the line chart
                    tension: 0.4,
                    pointRadius: 6,
                    pointHoverRadius: 10,
                    pointStyle: 'circle',
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            layout: {
                padding: {
                    left: 10, // Adjust these values to reduce the space
                    right: 10,
                    top: 10,
                    bottom: 10
                }
            },
            plugins: {
                tooltip: {
                    enabled: true,
                    mode: 'nearest',
                    intersect: false,
                    callbacks: {
                        label: function(context) {
                            return `${context.dataset.label}: ${context.raw}`;
                        }
                    }
                },
                legend: {
                    position: 'top',
                    labels: {
                        usePointStyle: true, // Adjusts the color box style
                        boxWidth: 20,        // Increase box width for better click handling
                        padding: 25,         // Increase padding between items for a larger click area
                    },
                    onClick: function(e, legendItem, legend) {
                        const chart = legend.chart;
                        const datasetIndex = legendItem.datasetIndex;
                        const dataset = chart.data.datasets[datasetIndex];

                        // Log or perform a custom action
                        console.log(`Legend clicked: ${legendItem.text}`);
                        console.log(`Dataset index: ${datasetIndex}`);

                        // Toggle visibility
                        dataset.hidden = !dataset.hidden;
                        chart.update();
                    },
                },
                title: {
                    display: true,
                    text: 'Resolved Tickets for Last 6 Months'
                }
            },
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Months'
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Number of Tickets'
                    },
                    min: 0,
                    suggestedMax: Math.max(...chartData.groupedTickets[1], ...chartData.groupedTickets[2]) + 50
                }
            },
            onHover: function(event, chartElement) {
                const canvas = event.native ? event.native.target : event.target; // Ensure cross-version support
                canvas.style.cursor = chartElement.length ? 'pointer' : 'default';
            }
        },
        plugins: [ChartDataLabels]
    });

});