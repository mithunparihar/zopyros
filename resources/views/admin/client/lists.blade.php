@extends('admin.layouts.app')
@section('metatitle', 'Clients : ' . \Content::ProjectName())
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-datatable table-responsive">
                <div class="card-header">
                    <div class="head-label d-flex justify-content-between">
                        <h5 class="card-title mb-0">Clients</h5>
                    </div>
                </div>
                <div class="container">
                    @livewire('admin.client.update-form')
                </div>
            </div>
        </div>
    </div>
@endsection
@push('css')
@endpush
@push('js')
    <script>
        let root = document.querySelector('[drag-root]');
        root.querySelectorAll('[drag-item]').forEach(element => {
            element.addEventListener('dragstart', el => {
                console.warn('Start');
                el.target.setAttribute('dragging', true);
            });
            element.addEventListener('drop', el => {
                el.target.classList.remove('bg-warning');
                let dragging = root.querySelector('[dragging]');
                el.target.before(dragging);

                let component = Livewire.find(
                    el.target.closest('[wire\\:id]').getAttribute('wire:id')
                );

                let imageIds = Array.from(
                        root.querySelectorAll('[drag-item]'))
                    .map(itemEl => itemEl.getAttribute('drag-item'));
                component.call('updateImageOrder', imageIds)
            });
            element.addEventListener('dragenter', el => {
                el.target.classList.add('bg-warning');
                el.preventDefault();
            });
            element.addEventListener('dragover', el => {
                el.preventDefault();
            });
            element.addEventListener('dragleave', el => {
                el.target.classList.remove('bg-warning');
                console.warn('Leave');
            });
            element.addEventListener('dragend', el => {
                console.warn('End');
                el.target.removeAttribute('dragging', true);
            });
        });
    </script>
@endpush
