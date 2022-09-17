<div class="block block-rounded">
    <div class="block-content bg-body-light" style="padding: 12px 20px;">
        <div class="row">
            <div class="col-md-3">
                <h3 class="block-title pt-1">{{ __('back/action.items') }}</h3>
            </div>
            <div class="col-md-9">
                <div class="block-options">
                    <input type="search" wire:model.debounce.300ms="search" class="form-control" style="display: block;" placeholder="{{ __('back/action.search') }}">
                    @if( ! empty($search_results))
                        <div class="autocomplete" >
                            <div id="myInputautocomplete-list" class="autocomplete-items">
                                @foreach($search_results as $item)
                                    <div wire:click="addItem({{ $item->apartment_id }})">{{ isset($item->title) ? $item->title : '' }}</div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>
    <div class="block-content">
        <!-- All Products Table -->
        <div class="table-responsive">
            <table class="table table-sm table-borderless table-striped table-vcenter">
                <thead>
                <tr>
                    <th>{{ __('back/action.title') }}</th>
                    <th class="text-right" style="width: 100px;">{{ __('back/action.delete') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($list as $item)
                    <tr>
                        <td class="font-size-sm">
                            {{ isset($item['title']) ? $item['title'] : '' }}
                            <input type="hidden" name="action_list[{{ isset($item['id']) ? $item['id'] : '' }}]" value="{{ isset($item['id']) ? $item['id'] : '' }}">
                        </td>
                        <td class="text-right font-size-sm">
                            <a class="btn btn-sm btn-alt-secondary" href="javascript:void(0)" wire:click="removeItem({{ isset($item['id']) ? $item['id'] : '' }})">
                                <i class="fa fa-fw fa-times text-danger"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <input type="hidden" value="{{ $group }}" name="group">

    </div>
</div>
