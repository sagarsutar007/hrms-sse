<x-adminlte-modal id="congratulationsModal" title="Congratulations" theme="success" icon="fas fa-check-circle" size="lg" static-backdrop>
    <div class="text-center">
        <h2>🎉 Congratulations 🎉</h2>
        <hr>
    </div>

    <p><b>Name :</b> {{ $add->f_name }} {{ $add->m_name }} {{ $add->l_name }}</p>
    <p><b>Email :</b> {{ $add->email }}</p>
    <p><b>Mobile :</b> {{ $add->m_number }}</p>
    <p><b>User ID :</b> {{ $Employee_id }}</p>
    <p><b>Password :</b> {{ $Password }}</p>

    <x-slot name="footerSlot">
        <x-adminlte-button label="Close" theme="danger" icon="fas fa-times" data-dismiss="modal" />
    </x-slot>
</x-adminlte-modal>

<script>
    $(document).ready(function() {
        $('#congratulationsModal').modal('show');
    });
</script>
