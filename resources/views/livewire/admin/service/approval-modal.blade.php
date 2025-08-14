<div class="modal-body p-0">
    <button type="button" onclick="window.location.reload()" class="btn-close"></button>
    <div class="mb-6">
        <div class="">
            <h5 class="mb-2 text-center"><u>Approval Information</u></h5>
            <div class="d-flex align-items-center gap-2">
                <x-image-preview :options="['class' => 'defaultimg', 'id' => 'blah']" imagepath="service" :image="$productInfo->primaryimage->image ?? ''" />
                <div>
                    <p class="mb-0">{{ $productInfo->title ?? '' }}</p>
                    <span>Category: {{ $productInfo->categoryInfo->title ?? '' }}</span>
                </div>
            </div>
        </div>
        <hr>
        <form wire:submit="ApprovalStatus" class="row">
            <div class="mb-2 col-md-12">
                <x-admin.form.label for="status" class="form-label" :asterisk="true" title="Approval Status" />
                <x-admin.form.select-box name="status" live="true" :lists="[['id' => 1, 'title' => 'Approved'], ['id' => 2, 'title' => 'Disapproved']]" :selectOptions="['id' => 'section']" />
                <x-admin.form.invalid-error errorFor="status" />
            </div>

            @if ($status == 2)
                <div class="col-md-12 mt-2">
                    <x-admin.form.label for="reason" class="form-label" :asterisk="false"
                        title="Disapproved Reason" />
                    <x-admin.form.text-editor name="reason" :editorOptions="[
                        'id' => 'reason',
                        'placeholder' => 'Write something here...',
                        'value' => $reason,
                    ]" />
                    <x-admin.form.invalid-error errorFor="reason" />
                </div>
            @endif
            <x-admin.form.save-button className="text-center" buttonName="{{ \App\Enums\ButtonText::UPDATE }}" />
        </form>
    </div>
</div>
