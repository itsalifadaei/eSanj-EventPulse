const {createApp} = Vue;

createApp({
    data() {
        return {
            eventType: 'all',
            hourlyChart: null,
            topUsersChart: null,
            pollingTimer: null,
            useSSE: false,
        }
    },
    methods: {
        async fetchCharts() {
            try {
                const params = new URLSearchParams({event_type: this.eventType});
                const [hourlyRes, topUsersRes] = await Promise.all([
                    fetch(`${window.APP_CONFIG.API_BASE_URL}/stats/hourly?${params}`),
                    fetch(`${window.APP_CONFIG.API_BASE_URL}/stats/top-users?${params}`),
                ]);

                const hourlyData = await hourlyRes.json();
                const topUsersData = await topUsersRes.json();

                this.renderHourlyChart(hourlyData);
                this.renderTopUsersChart(topUsersData);

            } catch (error) {
                console.error('خطا در دریافت داده:', error);
            }
        },
        renderHourlyChart(data) {
            if (this.hourlyChart) this.hourlyChart.destroy();
            const ctx = document.getElementById('hourlyChart').getContext('2d');
            this.hourlyChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: data.hours,
                    datasets: [{
                        label: 'تعداد رویدادها در هر ساعت',
                        data: data.counts,
                        backgroundColor: '#3498db',
                    }]
                },
                options: {
                    responsive: true,
                    scales: {y: {beginAtZero: true}}
                }
            });
        },
        renderTopUsersChart(data) {
            if (this.topUsersChart) this.topUsersChart.destroy();
            const ctx = document.getElementById('topUsersChart').getContext('2d');
            this.topUsersChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: data.users,
                    datasets: [{
                        label: 'تعداد رویدادهای کاربران',
                        data: data.counts,
                        backgroundColor: '#2ecc71',
                    }]
                },
                options: {
                    responsive: true,
                    indexAxis: 'y',
                    scales: {x: {beginAtZero: true}}
                }
            });
        },
        startPolling() {
            this.pollingTimer = setInterval(() => {
                this.fetchCharts();
            }, window.APP_CONFIG.REFRESH_INTERVAL);
        },
        onEventTypeChange() {
            clearInterval(this.pollingTimer);
            this.fetchCharts();
            this.startPolling();
        }
    },
    mounted() {
        this.fetchCharts();
        this.startPolling();
    }
}).mount('#app');