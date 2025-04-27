// app.js

const { createApp } = Vue;

let hourlyChart = null;
let topUsersChart = null;

createApp({
    data() {
        return {
            eventType: 'all',
            fetchInterval: null
        };
    },
    mounted() {
        this.fetchAndRender();
        this.fetchInterval = setInterval(this.fetchAndRender, 5000);
        Chart.defaults.font.size = 12;
        Chart.defaults.font.family = 'Vazir, sans-serif';
    },
    beforeUnmount() {
        clearInterval(this.fetchInterval);
    },
    methods: {
        async fetchAndRender() {
            try {
                const [hourlyData, topUsersData] = await Promise.all([
                    this.fetchHourlyData(),
                    this.fetchTopUsersData()
                ]);

                this.renderHourlyChart(hourlyData.data);
                this.renderTopUsersChart(topUsersData.data);
            } catch (err) {
                console.error('خطا هنگام دریافت داده‌ها:', err);
            }
        },
        async fetchHourlyData() {
            const response = await fetch(`/stats/hourly?event_type=${this.eventType}`);
            if (!response.ok) throw new Error('ایراد در دریافت hourly data');
            return await response.json();
        },
        async fetchTopUsersData() {
            const response = await fetch(`/stats/top-users?event_type=${this.eventType}&limit=10`);
            if (!response.ok) throw new Error('ایراد در دریافت top users');
            return await response.json();
        },
        renderHourlyChart(data) {
            const canvas = document.getElementById('hourlyChart');
            if (!canvas) return;
            const ctx = canvas.getContext('2d');

            const labels = data.map(item => {
                const d = new Date(item.date);
                const h = d.getHours().toString().padStart(2, '0');
                const m = d.getMinutes().toString().padStart(2, '0');
                return `${h}:${m}`;
            });

            const counts = data.map(item => item.count);

            if (hourlyChart) {
                hourlyChart.data.labels = labels;
                hourlyChart.data.datasets[0].data = counts;
                hourlyChart.update();
            } else {
                hourlyChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels,
                        datasets: [{
                            label: 'تعداد رویدادها',
                            data: counts,
                            backgroundColor: '#3498db',
                            borderRadius: 10
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: { beginAtZero: true }
                        },
                        animation: false
                    }
                });
            }
        },
        renderTopUsersChart(data) {
            const canvas = document.getElementById('topUsersChart');
            if (!canvas) return;
            const ctx = canvas.getContext('2d');

            const labels = data.map(item => item.user_id);
            const counts = data.map(item => item.count);

            if (topUsersChart) {
                topUsersChart.data.labels = labels;
                topUsersChart.data.datasets[0].data = counts;
                topUsersChart.update();
            } else {
                topUsersChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels,
                        datasets: [{
                            label: 'تعداد رویداد کاربران',
                            data: counts,
                            backgroundColor: '#2ecc71',
                            borderRadius: 10
                        }]
                    },
                    options: {
                        responsive: true,
                        indexAxis: 'y',
                        scales: {
                            x: { beginAtZero: true }
                        },
                        animation: false
                    }
                });

            }
        },
        onEventTypeChange() {
            this.fetchAndRender();
        }
    }
}).mount('#app');