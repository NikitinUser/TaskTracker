window.onload = function () {
    getCounTasks();
}

function getCounTasks() {
    
    ajaxGet('getCounTasks', function(data) {
        if(data != ''){
            data = JSON.parse(data);

            drawStat(data);
            //console.log(data);
        }
    });
}

function drawStat(data) {
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Активные', 'Всего завершено', 'В архиве'],
            datasets: [{
                label: '# of Votes',
                data: [data.countActive, data.countDone, data.countArchive],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(54, 162, 235, 1)',
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}