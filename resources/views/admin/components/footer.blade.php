<!-- Modal -->
<div class="modal fade" id="result-modal" tabindex="-1" aria-labelledby="result-modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-3"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="messages"></div>
            </div>
        </div>
    </div>
</div>

<script src="https://kit.fontawesome.com/a4cfe3a7ca.js" crossorigin="anonymous"></script>
<script src="{{ mix('assets/js/admin/admin.js') }}"></script>

@if ($errors->any())
    <script>
        $(function() {
            showError(@json($errors->all(), JSON_UNESCAPED_UNICODE));
        })
    </script>
@endif

@if (session('success'))
    <script>
        $(function() {
            showMessage(@json(session('success'), JSON_UNESCAPED_UNICODE));
        });
    </script>
@endif

@yield('extra_js')
