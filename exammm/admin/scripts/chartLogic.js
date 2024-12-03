$(document).ready(() => {
  const fetchReaders = () => {
    $.ajax({
      url: 'database/readers/readers.php',
      type: 'GET',
      success: (res) => {
        const readers = JSON.parse(res);
        let dateCount = {};

        const currentDate = new Date();

        readers.forEach((reader) => {
          let date = reader.date.split(' ')[0];
          let readerDate = new Date(date);

          const diffTime = Math.abs(currentDate - readerDate);
          const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

          if (diffDays <= 7) {
            if (dateCount[date]) {
              dateCount[date]++;
            } else {
              dateCount[date] = 1;
            }
          }
        });

        new Chart('chart', {
          type: 'line',

          data: {
            labels: Object.keys(dateCount).reverse(),
            datasets: [
              {
                label: 'Lasītāji',
                backgroundColor: '#fed7aa',
                borderColor: '#F0EAE5',
                fill: true,
                data: Object.values(dateCount).reverse(),
                tension: 0.4,
              },
            ],
          },
          options: {
            plugins: {
              tooltip: {
                enabled: true,
              },
              legend: {
                display: false,
              },
            },
            responsive: true,
            maintainAspectRatio: false,
          },
        });
      },
      error: (err) => {
        console.log(err);
      },
    });
  };

  fetchReaders();
});
