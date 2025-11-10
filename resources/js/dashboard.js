// ====================================================
// 📈 SMART OLT - Real-Time Dashboard Line Chart (Fix)
// Dengan efek naik-turun lembut & auto refresh stabil
// ====================================================

import Chart from "chart.js/auto";

if (window.location.pathname.includes("/dashboard")) {
    let statsChart = null;
    let countdownInterval = null;
    let refreshInterval = null;
    const refreshSeconds = 180;
    let countdownSeconds = refreshSeconds;
    const dashboardMode = window.dashboardMode || "realtime";
    const isRealtime = dashboardMode === "realtime";

    document.addEventListener("DOMContentLoaded", () => {
        const chartEl = document.getElementById("statsChart");
        if (!chartEl) return;

        initChart();
        updateClock();
        updateTimeRange();

        if (isRealtime) {
            fetchDashboardData();
            startAutoRefresh();
            startCountdown();
        }
    });

    // ======================== LABEL WAKTU =======================
    function generateTimeLabels() {
        const now = new Date();
        const labels = [];
        for (let i = 20; i >= 0; i--) {
            const t = new Date(now - i * 3 * 60000);
            labels.push(
                t.toLocaleTimeString("id-ID", {
                    hour: "2-digit",
                    minute: "2-digit",
                })
            );
        }
        return labels;
    }

    // ======================== FLUKTUASI =======================
    function smoothFluctuation(base, maxFluct = 1.2) {
        // Efek naik-turun lembut: ±maxFluct%
        const factor = 1 + ((Math.random() - 0.5) * maxFluct) / 100;
        return Math.max(0, base * factor);
    }

    // ======================== INISIALISASI =======================
    function initChart() {
        const ctx = document.getElementById("statsChart").getContext("2d");
        const labels = generateTimeLabels();

        const gradGreen = ctx.createLinearGradient(0, 0, 0, 300);
        gradGreen.addColorStop(0, "rgba(16,185,129,0.4)");
        gradGreen.addColorStop(1, "rgba(16,185,129,0.05)");

        const gradRed = ctx.createLinearGradient(0, 0, 0, 300);
        gradRed.addColorStop(0, "rgba(239,68,68,0.4)");
        gradRed.addColorStop(1, "rgba(239,68,68,0.05)");

        statsChart = new Chart(ctx, {
            type: "line",
            data: {
                labels,
                datasets: [
                    {
                        label: "Online",
                        borderColor: "#10B981",
                        backgroundColor: gradGreen,
                        borderWidth: 2,
                        fill: true,
                        tension: 0.25,
                        pointRadius: 2,
                        pointHoverRadius: 5,
                        data: Array.from({ length: labels.length }, () =>
                            smoothFluctuation(60)
                        ),
                    },
                    {
                        label: "LOS / Offline",
                        borderColor: "#EF4444",
                        backgroundColor: gradRed,
                        borderWidth: 2,
                        fill: true,
                        tension: 0.25,
                        pointRadius: 2,
                        pointHoverRadius: 5,
                        data: Array.from({ length: labels.length }, () =>
                            smoothFluctuation(10)
                        ),
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: {
                    duration: 500,
                    easing: "easeOutCubic",
                },
                plugins: {
                    legend: {
                        position: "top",
                        labels: {
                            color: "#374151",
                            usePointStyle: true,
                            padding: 20,
                            font: { size: 13, weight: "600" },
                        },
                    },
                    tooltip: {
                        backgroundColor: "rgba(17,17,17,0.9)",
                        titleFont: { size: 13, weight: "bold" },
                        bodyFont: { size: 12 },
                        padding: 10,
                        callbacks: {
                            title: (items) => "Pukul " + items[0].label,
                            label: (ctx) =>
                                `${ctx.dataset.label}: ${ctx.parsed.y.toFixed(
                                    2
                                )} pelanggan`,
                        },
                    },
                },
                scales: {
                    x: {
                        grid: {
                            color: "rgba(0,0,0,0.05)",
                            drawBorder: false,
                        },
                        ticks: {
                            color: "#6B7280",
                            font: { size: 10 },
                            maxRotation: 0,
                            minRotation: 0,
                        },
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: "rgba(0,0,0,0.08)",
                            drawBorder: false,
                        },
                        ticks: {
                            color: "#4B5563",
                            font: { size: 11 },
                            precision: 0,
                        },
                    },
                },
            },
        });
    }

    // ======================== FETCH =======================
    async function fetchDashboardData() {
        if (!isRealtime) return;
        try {
            const res = await fetch("/dashboard/refresh-data", {
                headers: { Accept: "application/json" },
            });
            const data = await res.json();
            updateChart(data);
            updateTimeRange();
        } catch (e) {
            console.error("❌ fetch error", e);
        }
    }

    // ======================== UPDATE CHART =======================
    function updateChart(data) {
        if (!statsChart) return;

        const online =
            data.onlineStats?.map((d) => smoothFluctuation(d.count, 1.5)) || [];
        const los =
            data.losStats?.map((d) => smoothFluctuation(d.count, 1.5)) || [];

        statsChart.data.labels = generateTimeLabels();
        statsChart.data.datasets[0].data = online;
        statsChart.data.datasets[1].data = los;
        statsChart.update("active");
    }

    // ======================== JAM & RANGE =======================
    function updateClock() {
        setInterval(() => {
            const el = document.getElementById("currentTime");
            if (el) {
                el.textContent = new Date().toLocaleTimeString("id-ID", {
                    hour: "2-digit",
                    minute: "2-digit",
                    second: "2-digit",
                });
            }
        }, 1000);
    }

    function updateTimeRange() {
        const from = document.getElementById("timeRangeFrom");
        const to = document.getElementById("timeRangeTo");
        if (!from || !to) return;
        const now = new Date();
        const past = new Date(now - 60 * 60 * 1000);
        from.textContent = past.toLocaleTimeString("id-ID", {
            hour: "2-digit",
            minute: "2-digit",
        });
        to.textContent = now.toLocaleTimeString("id-ID", {
            hour: "2-digit",
            minute: "2-digit",
        });
    }

    // ======================== REFRESH OTOMATIS =======================
    function startAutoRefresh() {
        clearInterval(refreshInterval);
        refreshInterval = setInterval(() => {
            fetchDashboardData();
            countdownSeconds = refreshSeconds;
        }, refreshSeconds * 1000);
    }

    function startCountdown() {
        clearInterval(countdownInterval);
        countdownInterval = setInterval(() => {
            countdownSeconds--;
            if (countdownSeconds <= 0) countdownSeconds = refreshSeconds;
            const el = document.getElementById("countdown");
            if (el) {
                const m = Math.floor(countdownSeconds / 60);
                const s = countdownSeconds % 60;
                el.textContent = `${m}:${s.toString().padStart(2, "0")}`;
            }
        }, 1000);
    }
}
