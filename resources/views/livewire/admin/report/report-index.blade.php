<div>
    <div class="card">
        <div class="card-header py-3 d-flex justify-content-between">
            <div class="d-flex gap-2">
                <div>
                    <input wire:model.live="search" type="text" class="form-control" placeholder="Tìm kiếm...">
                </div>
            </div>
        </div>

        <div class="table-responsive-md">
            <table class="table fs-table ">
                <thead>
                    <tr class="table-light">
                        <th>STT</th>
                        <th>Đợt đăng ký</th>
                        <th>Hạn nộp báo cáo</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($campaigns as $campaign)
                        <tr>
                            <td width="5%">{{ $loop->index + 1 + $campaigns->perPage() * ($campaigns->currentPage() - 1) }}</td>
                            <td width="50%">
                                @can('view', \App\Models\GroupOfficial::class)
                                <a href="{{ route('admin.reports.show', $campaign->id) }}?search={{ urlencode($search) }}">
                                    {{ $campaign->name }}
                                </a>
                                @else
                                    {{ $campaign->name }}
                                @endcan
                            </td>
                            <td width="15%">
                                {{ \Carbon\Carbon::parse($campaign->report_deadline)->format('d/m/Y') }}
                            </td>
                        </tr>
                    @empty
                        <x-table.table-empty :colspan="3" />
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    {{ $campaigns->links('vendor.pagination.theme') }}
</div>

