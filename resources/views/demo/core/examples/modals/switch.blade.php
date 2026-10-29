<div>
    {{-- modal.switch liest $modalName, $modalTitle, $modalSize, $modalSwitch
         (ModalTrait) – hier der Fall editField mit $modalField = 'memo' --}}
    <x-modal.button modid="demoSwitchModal" type="outline-primary">modal.switch öffnen</x-modal.button>

    @include('core::modal.switch')

    <p class="small text-body-secondary mt-3 mb-0">memo = „{{ $memo }}“</p>
</div>
