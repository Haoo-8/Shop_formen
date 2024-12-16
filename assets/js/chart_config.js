document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('revenueChart').getContext('2d');
    let chart;

    const fetchData = (startDate, endDate) => {
        const formData = new FormData();
        formData.append('start_date', startDate);
        formData.append('end_date', endDate);

        fetch('fetch_report_data.php', {
            method: 'POST',
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            updateStatistics(data);
            updateChart(data.monthly_revenue);
        })
        .catch(error => console.error('Error fetching report data:', error));
    };

    const updateStatistics = (data) => {
        document.getElementById('totalRevenue').textContent = `${data.total_revenue.toLocaleString()} VND`;
        document.getElementById('totalOrders').textContent = data.total_orders;
        document.getElementById('totalProducts').textContent = data.total_products;
    };

    const updateChart = (monthlyRevenue) => {
        const labels = monthlyRevenue.map(item => `Tháng ${item.month}`);
        const revenues = monthlyRevenue.map(item => item.revenue);

        if (chart) chart.destroy();

        chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Doanh thu (VND)',
                    data: revenues,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1,
                }],
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                    },
                },
            },
        });
    };

    // Lấy giá trị mặc định
    const startDateInput = document.querySelector('[name="start_date"]');
    const endDateInput = document.querySelector('[name="end_date"]');

    startDateInput.addEventListener('change', () => fetchData(startDateInput.value, endDateInput.value));
    endDateInput.addEventListener('change', () => fetchData(startDateInput.value, endDateInput.value));

    fetchData(startDateInput.value, endDateInput.value);
});
