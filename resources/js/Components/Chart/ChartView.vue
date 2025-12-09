<template>
    <div class="w-full">
        <div
            class="flex items-center justify-between mb-4"
            v-if="title || useFilter"
        >
            <div class="text-lg font-bold" v-if="title">
                {{ titlePrefix }}{{ namaBulan }}
            </div>

            <div v-if="useFilter" class="flex items-center space-x-2">
                <label class="text-sm font-semibold text-gray-700"
                    >Pilih Bulan:</label
                >
                <select
                    v-model="selectedMonth"
                    @change="fetchChartData"
                    class="px-2 py-1 border rounded"
                >
                    <option
                        v-for="(bulan, index) in bulanOptions"
                        :key="index"
                        :value="index"
                    >
                        {{ bulan }}
                    </option>
                </select>
            </div>
        </div>

        <div ref="canvasWrapper" :style="{ height: heightStyle }">
            <canvas ref="chartCanvas"></canvas>
        </div>
    </div>
</template>

<script setup>
import { onMounted, ref, watch, computed } from "vue";
import { Chart } from "chart.js/auto";

// Props
const props = defineProps({
    chartUri: { type: String, required: true },
    title: { type: String, default: "" },
    useFilter: { type: Boolean, default: false },
    width: { type: [String, Number], default: "100%" },
    height: { type: [String, Number], default: "300px" },
    type: { type: String, default: "line" },
    options: {
        type: Object,
        default: () => ({
            responsive: false,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: (context) => {
                            const label = context.label || "";
                            const value = context.parsed.y || 0;
                            return `${label}: ${value}`;
                        },
                    },
                },
            },
            scales: {
                x: {
                    ticks: {
                        callback: (_, index) => `Tgl ${index + 1}`,
                    },
                },
            },
        }),
    },
});
const heightStyle = computed(() => {
    return typeof props.height === "number"
        ? `${props.height}px`
        : props.height;
});
// States
const chartCanvas = ref(null);
const chartInstance = ref(null);

const selectedMonth = ref(new Date().getMonth()); // index 0-11
const namaBulan = ref("");
const labels = ref([]);
const dataPoints = ref([]);

const bulanOptions = [
    "Januari",
    "Februari",
    "Maret",
    "April",
    "Mei",
    "Juni",
    "Juli",
    "Agustus",
    "September",
    "Oktober",
    "November",
    "Desember",
];

const titlePrefix = computed(() => {
    return props.title ? `${props.title} - ` : "";
});

// Computed
const chartData = computed(() => ({
    labels: labels.value,
    datasets: [
        {
            label: "Jumlah Harian",
            data: dataPoints.value,
            backgroundColor: dataPoints.value.map(() => randomColor()),
            tension: 0.5,
        },
    ],
}));

// Methods
function randomColor() {
    const colors = [
        "#f87171",
        "#facc15",
        "#34d399",
        "#60a5fa",
        "#a78bfa",
        "#f472b6",
        "#fb923c",
        "#4ade80",
        "#c084fc",
        "#fcd34d",
        "#818cf8",
        "#f43f5e",
        "#86efac",
        "#a3e635",
        "#ec4899",
        "#fbbf24",
        "#38bdf8",
        "#c026d3",
        "#10b981",
        "#3b82f6",
    ];
    return colors[Math.floor(Math.random() * colors.length)];
}

async function fetchChartData() {
    try {
        const params = props.useFilter
            ? { bulan: selectedMonth.value + 1 }
            : {};
        const response = await axios.get(props.chartUri, { params });
        if (response && response.data) {
            labels.value = response.data.labels ?? [];
            dataPoints.value = response.data.data ?? [];
            namaBulan.value =
                response.data.namaBulan || bulanOptions[selectedMonth.value];
            renderChart();
        }
    } catch (error) {
        console.error("Gagal fetch data chart:", error);
    }
}

function renderChart() {
    if (chartInstance.value) {
        chartInstance.value.destroy();
    }

    const ctx = chartCanvas.value.getContext("2d");
    chartInstance.value = new Chart(ctx, {
        type: props.type,
        data: chartData.value,
        options: props.options,
    });
}

// Lifecycle
onMounted(() => {
    fetchChartData();
});

watch(
    () => props.chartUri,
    () => {
        fetchChartData();
    }
);
</script>

<style scoped>
canvas {
    display: block;
    max-width: 100%;
}
</style>
