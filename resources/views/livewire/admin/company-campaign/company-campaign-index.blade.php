<div>
    <div class="card">
        <div class="card-header py-3 d-flex justify-content-between">
            <div class="d-flex gap-2">
                <div>
                    <input wire:model.live="search" type="text" class="form-control" placeholder="Tìm kiếm...">
                </div>
            </div>
            <div class="d-flex gap-2">
                <div>
                    <button type="button" class="btn btn-light btn-icon px-2" @click="$wire.$refresh">
                        <i class="ph-arrows-clockwise px-1"></i><span>Tải lại</span>
                    </button>
                </div>
            </div>
        </div>

        <div class="table-responsive-md">
            <table class="table fs-table ">
                <thead>
                    <tr class="table-light">
                        <th>STT</th>
                        <th>Đợt đăng ký</th>
                        <th>Số công ty trong đợt</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($campaigns as $campaign)
                        <tr>
                            <td>{{ $loop->index + 1 + $campaigns->perPage() * ($campaigns->currentPage() - 1) }}</td>
                            <td>
                                @can('viewCompanyCampaign', $campaign)
                                    <a href="{{ route('admin.company-campaign.show', $campaign->id) }}">
                                        {{ $campaign->name }}
                                    </a>
                                @else
                                    {{ $campaign->name }}
                                @endcan
                            </td>
                            
                            <td>
                                {{ $campaign->companies->count() ?? 0 }}
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
