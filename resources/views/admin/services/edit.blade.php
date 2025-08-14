@extends('admin.layouts.app')
@section('metatitle', 'Service Edit : ' . \Content::ProjectName())
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-datatable table-responsive">
                <div class="card-header">
                    <div class="head-label d-flex justify-content-between">
                        <h5 class="card-title mb-0">Service {{ $disabled ? 'Information' : 'Edit' }}</h5>
                        <x-admin.button.back />
                    </div>
                </div>
            </div>
        </div>

        @livewire('admin.service.update-form', ['data' => $product->id, 'disabled' => $disabled])
    </div>
@endsection
@push('css')
    <style>
        .setPrimary {
            position: relative;
        }

        .notPrimary .btn-success,
        .notPrimary .badge {
            display: none;
        }

        .setPrimary .btn-success,
        .setPrimary .badge {
            display: block;
        }

        .setPrimary .btn-label-danger,
        .notPrimary .btn-label-danger {
            width: 26px;
            height: 26px;
            position: absolute;
            top: -11px;
            right: 0;
        }

        .setPrimary .btn-success {
            width: 25px;
            height: 25px;
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            top: 0;
            margin: auto;
        }

        .disabledForm input,
        .disabledForm select,
        .disabledForm textarea {
            pointer-events: none;
            cursor: not-allowed;
            background: #f1f1f1
        }

        .disabledForm .setPrimary .btn-success,
        .disabledForm .btn-label-danger {
            display: none;
        }
        img.defaultimg{background:#fff!important}
    </style>
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
