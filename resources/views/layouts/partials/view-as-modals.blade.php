@if(auth()->user()->role?->name === 'SuperAdmin')
{{-- Same structure as dashboard modals (Assign instructor, Transfer, Reject enrollment) --}}
<div class="modal fade" id="modalViewAsAdmin" tabindex="-1" aria-labelledby="modalViewAsAdminLabel" aria-hidden="true" data-bs-backdrop="true" data-bs-keyboard="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="{{ route('super-admin.view-as.store') }}">
                @csrf
                <input type="hidden" name="role" value="Admin">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalViewAsAdminLabel">Which admin do you want to view?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label for="view_as_admin_id" class="form-label small mb-0">Admin</label>
                    <select name="user_id" id="view_as_admin_id" class="form-select form-select-sm" required>
                        <option value="">Select admin</option>
                        @foreach($viewAsAdmins ?? [] as $u)
                            <option value="{{ $u->id }}">{{ $u->name }} ({{ $u->email }})</option>
                        @endforeach
                    </select>
                    @if(empty($viewAsAdmins) || $viewAsAdmins->isEmpty())
                        <p class="small text-muted mt-2 mb-0">No admins yet.</p>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning" @if(empty($viewAsAdmins) || $viewAsAdmins->isEmpty()) disabled @endif>View dashboard</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="modalViewAsInstructor" tabindex="-1" aria-labelledby="modalViewAsInstructorLabel" aria-hidden="true" data-bs-backdrop="true" data-bs-keyboard="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="{{ route('super-admin.view-as.store') }}">
                @csrf
                <input type="hidden" name="role" value="Instructor">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalViewAsInstructorLabel">Which instructor do you want to view?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label for="view_as_instructor_id" class="form-label small mb-0">Instructor</label>
                    <select name="user_id" id="view_as_instructor_id" class="form-select form-select-sm" required>
                        <option value="">Select instructor</option>
                        @foreach($viewAsInstructors ?? [] as $u)
                            <option value="{{ $u->id }}">{{ $u->name }} ({{ $u->email }})</option>
                        @endforeach
                    </select>
                    @if(empty($viewAsInstructors) || $viewAsInstructors->isEmpty())
                        <p class="small text-muted mt-2 mb-0">No instructors yet.</p>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-info" @if(empty($viewAsInstructors) || $viewAsInstructors->isEmpty()) disabled @endif>View dashboard</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="modalViewAsStudent" tabindex="-1" aria-labelledby="modalViewAsStudentLabel" aria-hidden="true" data-bs-backdrop="true" data-bs-keyboard="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="{{ route('super-admin.view-as.store') }}">
                @csrf
                <input type="hidden" name="role" value="Student">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalViewAsStudentLabel">Which student do you want to view?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label for="view_as_student_id" class="form-label small mb-0">Student</label>
                    <select name="user_id" id="view_as_student_id" class="form-select form-select-sm" required>
                        <option value="">Select student</option>
                        @foreach($viewAsStudents ?? [] as $u)
                            <option value="{{ $u->id }}">{{ $u->name }} ({{ $u->email }})</option>
                        @endforeach
                    </select>
                    @if(empty($viewAsStudents) || $viewAsStudents->isEmpty())
                        <p class="small text-muted mt-2 mb-0">No students yet.</p>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" @if(empty($viewAsStudents) || $viewAsStudents->isEmpty()) disabled @endif>View dashboard</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var open = '{{ request()->get('open', '') }}';
    if (open && ['admin', 'instructor', 'student'].indexOf(open) !== -1) {
        var id = 'modalViewAs' + open.charAt(0).toUpperCase() + open.slice(1);
        var el = document.getElementById(id);
        if (el && typeof bootstrap !== 'undefined') {
            new bootstrap.Modal(el).show();
        }
    }
    [].slice.call(document.querySelectorAll('#modalViewAsAdmin, #modalViewAsInstructor, #modalViewAsStudent')).forEach(function(modalEl) {
        modalEl.addEventListener('hidden.bs.modal', function() {
            document.body.classList.remove('modal-open');
            document.body.style.overflow = '';
            document.body.style.paddingRight = '';
            var backdrops = document.querySelectorAll('.modal-backdrop');
            backdrops.forEach(function(b) { b.remove(); });
        });
    });
});
</script>
@endif
