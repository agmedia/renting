<div class="mb-0 input-group">
    <input type="search" wire:model.debounce.300ms="search" class="form-control form-control-lg @error('publisher_id') is-invalid @enderror" id="publisher-input" placeholder="Dodaj autora..." autocomplete="off">
    <input type="hidden" wire:model="publisher_id" name="publisher_id">
    <span class="input-group-append" data-toggle="modal" data-target="#new-publisher-modal">
        <a href="javascript:void(0)" wire:click="viewAddWindow" class="btn btn-secondary btn-search"><i class="fa fa-plus pt-2"></i></a>
    </span>

    <div class="autocomplete p-3" @if( ! $show_add_window) hidden @endif style="position:absolute; z-index:10; top:38px; background-color: #f6f6f6; border: 1px solid #d7d7d7;">
        <div class="row">
            <div class="mb-4 col-sm-12 col-md-6">
                <label class="form-label required" for="input-title">Ime nakladnika</label>
                <input type="text" class="form-control form-control-lg @if (session()->has('title')) is-invalid @endif" id="input-title" wire:model.defer="new.title" placeholder="">
                @if (session()->has('title')) <label class="small text-danger">Ime nakladnika je obvezno...</label> @endif
            </div>

            <div class="mb-0 mt-4 col-md-12 text-right">
                <a href="javascript:void(0)" wire:click="makeNewPublisher" class="btn btn-primary btn-save shadow-sm">
                    <i class="align-middle" data-feather="save">&nbsp;</i> Snimi
                </a>
            </div>
        </div>
    </div>

    @if( ! empty($search_results))
        <div class="autocomplete pt-3" style="position:unset; background-color: #f6f6f6;">
            <div id="myInputautocomplete-list" class="autocomplete-items">
                @foreach($search_results as $publisher)
                    <div style="cursor: pointer;" wire:click="addPublisher('{{ $publisher->id }}')">
                        <small class="font-weight-lighter">Ime: <strong>{{ $publisher->title }}</strong><br>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    @push('scripts')
        <script>
            document.addEventListener('livewire:load', function () {

            });

            Livewire.on('success_alert', () => {
                successNotify();
            });

            Livewire.on('error_alert', (e) => {
                errorNotify(e.message);
            });
        </script>
    @endpush

</div>
