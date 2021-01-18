function dynamicColors() {
    const r = Math.floor(Math.random() * 255);
    const g = Math.floor(Math.random() * 255);
    const b = Math.floor(Math.random() * 255);
    return "rgb(" + r + "," + g + "," + b + ")";
}

function genPieChart(element, title, labels, datas) {
    new Chart(document.getElementById(element).getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: labels,
            datasets: [{
                label: title,
                backgroundColor: () => {
                    let backgroundColor = []
                    datas.forEach(() => backgroundColor.push(dynamicColors()))
                    return backgroundColor
                },
                data: datas
            }]
        },
        options: {
            legend: {
                display: false
            }
        }
    });
}

function genLineChart(element, title, labels, datas) {
    new Chart(document.getElementById(element).getContext('2d'), {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: title,
                backgroundColor: 'rgba(54,162,235,.7)',
                data: datas,
            }]
        },
        options: {
            legend: {
                display: false
            },
            elements: {
                point:{
                    radius: 0
                }
            }
        }
    });
}

function genBarChart(element, title, labels, datas) {
    new Chart(document.getElementById(element).getContext('2d'), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: title,
                backgroundColor: 'rgba(30, 164, 113,.7)',
                data: datas,
            }]
        },
        options: {
            legend: {
                display: false
            }
        }
    });
}