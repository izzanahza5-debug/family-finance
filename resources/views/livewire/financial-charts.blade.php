<div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 mt-6" 
     x-data="{ 
        activeTab: 'family',
        // Menyimpan instance chart di dalam scope Alpine, bukan window global
        chartFamilyBar: null,
        chartFamilyDonut: null,
        chartPersonalBar: null,
        chartPersonalDonut: null,

        initCharts() {
            this.renderFamilyCharts();
            this.renderPersonalCharts();
        },
        renderFamilyCharts() {
            // Hancurkan chart lama jika ada menggunakan properti Alpine
            if (this.chartFamilyBar) this.chartFamilyBar.destroy();
            if (this.chartFamilyDonut) this.chartFamilyDonut.destroy();

            let elBar = document.getElementById('familyBarChart');
            if (elBar) {
                this.chartFamilyBar = new Chart(elBar.getContext('2d'), {
                    type: 'bar',
                    data: {
                        labels: @js($familyData['cashFlow']['labels']),
                        datasets: [{
                            data: @js($familyData['cashFlow']['data']),
                            backgroundColor: ['#10B981', '#F43F5E'],
                            borderRadius: 8
                        }]
                    },
                    options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } } }
                });
            }

            let elDonut = document.getElementById('familyDonutChart');
            if (elDonut) {
                this.chartFamilyDonut = new Chart(elDonut.getContext('2d'), {
                    type: 'doughnut',
                    data: {
                        labels: @js($familyData['categories']['labels']),
                        datasets: [{
                            data: @js($familyData['categories']['data']),
                            backgroundColor: ['#3B82F6', '#10B981', '#F59E0B', '#EF4444', '#8B5CF6', '#EC4899', '#6B7280']
                        }]
                    },
                    options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'bottom' } } }
                });
            }
        },
        renderPersonalCharts() {
            // Hancurkan chart lama jika ada menggunakan properti Alpine
            if (this.chartPersonalBar) this.chartPersonalBar.destroy();
            if (this.chartPersonalDonut) this.chartPersonalDonut.destroy();

            let elBar = document.getElementById('personalBarChart');
            if (elBar) {
                this.chartPersonalBar = new Chart(elBar.getContext('2d'), {
                    type: 'bar',
                    data: {
                        labels: @js($personalData['cashFlow']['labels']),
                        datasets: [{
                            data: @js($personalData['cashFlow']['data']),
                            backgroundColor: ['#10B981', '#F43F5E'],
                            borderRadius: 8
                        }]
                    },
                    options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } } }
                });
            }

            let elDonut = document.getElementById('personalDonutChart');
            if (elDonut) {
                this.chartPersonalDonut = new Chart(elDonut.getContext('2d'), {
                    type: 'doughnut',
                    data: {
                        labels: @js($personalData['categories']['labels']),
                        datasets: [{
                            data: @js($personalData['categories']['data']),
                            backgroundColor: ['#3B82F6', '#10B981', '#F59E0B', '#EF4444', '#8B5CF6', '#EC4899', '#6B7280']
                        }]
                    },
                    options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'bottom' } } }
                });
            }
        }
     }"
     x-init="initCharts(); $watch('activeTab', () => { setTimeout(() => initCharts(), 50) })"
     x-effect="setTimeout(() => initCharts(), 50)">

    <div class="flex flex-col md:flex-row md:justify-between md:items-center border-b border-gray-100 pb-5 gap-4">
        <div>
            <h3 class="text-xl font-extrabold text-gray-900">Analisis Visual Keuangan</h3>
            <p class="text-xs text-gray-500 mt-0.5">Pantau grafik pemasukan, pengeluaran, dan persentase kategori</p>
        </div>
        
        <div class="flex items-center space-x-2 bg-gray-50 p-1.5 rounded-xl border border-gray-200 w-fit">
            <input type="date" wire:model.live="startDate" class="bg-transparent border-none text-xs font-bold text-gray-700 focus:ring-0 p-1">
            <span class="text-xs font-bold text-gray-400">s/d</span>
            <input type="date" wire:model.live="endDate" class="bg-transparent border-none text-xs font-bold text-gray-700 focus:ring-0 p-1">
        </div>
    </div>

    <div class="flex bg-gray-100 p-1 rounded-xl w-full sm:w-72 mt-6">
        <button @click="activeTab = 'family'" 
                :class="activeTab === 'family' ? 'bg-white text-blue-600 shadow-sm' : 'text-gray-500 hover:text-gray-700'"
                class="flex-1 text-center text-sm font-bold py-2.5 rounded-lg transition duration-200">
            🏠 Chart Keluarga
        </button>
        <button @click="activeTab = 'personal'" 
                :class="activeTab === 'personal' ? 'bg-white text-emerald-600 shadow-sm' : 'text-gray-500 hover:text-gray-700'"
                class="flex-1 text-center text-sm font-bold py-2.5 rounded-lg transition duration-200">
            👨 Chart Pribadi
        </button>
    </div>

    <div class="mt-6">
        <div x-show="activeTab === 'family'" class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 flex flex-col items-center">
                <h5 class="text-sm font-bold text-gray-700 mb-4 self-start">Perbandingan Arus Kas (Rp)</h5>
                <div class="w-full h-64 relative">
                    <canvas id="familyBarChart"></canvas>
                </div>
            </div>
            <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 flex flex-col items-center">
                <h5 class="text-sm font-bold text-gray-700 mb-4 self-start">Persentase Spend Kategori Pengeluaran</h5>
                <div class="w-full h-64 relative">
                    <canvas id="familyDonutChart"></canvas>
                </div>
            </div>
        </div>

        <div x-show="activeTab === 'personal'" class="grid grid-cols-1 md:grid-cols-2 gap-8" style="display: none;">
            <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 flex flex-col items-center">
                <h5 class="text-sm font-bold text-gray-700 mb-4 self-start">Perbandingan Arus Kas Saya (Rp)</h5>
                <div class="w-full h-64 relative">
                    <canvas id="personalBarChart"></canvas>
                </div>
            </div>
            <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 flex flex-col items-center">
                <h5 class="text-sm font-bold text-gray-700 mb-4 self-start">Persentase Spend Kategori Pengeluaran Saya</h5>
                <div class="w-full h-64 relative">
                    <canvas id="personalDonutChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>