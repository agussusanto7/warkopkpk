@extends('admin.layout')
@section('title', 'Kelola Milestone')
@section('page_title', 'Kelola Milestone')

@section('content')
<div class="admin-toolbar">
    <div class="toolbar-info">
        <span class="total-badge">{{ $milestones->count() }} Milestone</span>
    </div>
    <button class="btn btn-primary" onclick="toggleForm()">
        <span>➕ Tambah Milestone</span>
    </button>
</div>

{{-- Form Tambah/Edit --}}
<div id="milestoneForm" class="admin-form-card" style="display:none; margin-bottom: 24px;">
    <h3 class="section-title" id="formTitle">➕ Tambah Milestone Baru</h3>
    <form id="milestoneFormElement" method="POST">
        @csrf
        <input type="hidden" name="_method" id="formMethod" value="POST">

        <div class="form-row-admin">
            <div class="form-group">
                <label for="year">Tahun *</label>
                <input type="number" id="year" name="year" required class="admin-input" placeholder="2024" min="2000" max="2100">
            </div>
            <div class="form-group">
                <label for="sort_order">Urutan</label>
                <input type="number" id="sort_order" name="sort_order" class="admin-input" placeholder="0" min="0">
            </div>
        </div>

        <div class="form-group">
            <label for="title">Judul Milestone *</label>
            <input type="text" id="title" name="title" required class="admin-input" placeholder="Contoh: 5000+ Cups Served">
        </div>

        <div class="form-group">
            <label for="description">Deskripsi</label>
            <textarea id="description" name="description" class="admin-input" rows="3" placeholder="Deskripsi milestone..."></textarea>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">💾 Simpan</button>
            <button type="button" class="btn btn-outline-admin" onclick="toggleForm()">Batal</button>
        </div>
    </form>
</div>

{{-- Alert Success --}}
@if(session('success'))
<div class="alert-success-admin">✅ {{ session('success') }}</div>
@endif

{{-- Tabel Milestone --}}
<div class="admin-card">
    @if($milestones->count() > 0)
    <table class="admin-table">
        <thead>
            <tr>
                <th>Tahun</th>
                <th>Judul</th>
                <th>Deskripsi</th>
                <th>Urutan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($milestones as $milestone)
            <tr>
                <td><strong>{{ $milestone->year }}</strong></td>
                <td><strong>{{ $milestone->title }}</strong></td>
                <td class="desc-cell">{{ $milestone->description ?? '-' }}</td>
                <td>{{ $milestone->sort_order }}</td>
                <td class="actions-cell">
                    <button type="button" class="action-btn edit" onclick="editMilestone({{ $milestone->id }}, {{ json_encode($milestone->only(['year', 'title', 'description', 'sort_order'])) }})" title="Edit">
                        ✏️
                    </button>
                    <form action="{{ route('admin.milestones.destroy', $milestone) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="action-btn delete" onclick="return confirm('Yakin ingin menghapus milestone ini?')" title="Hapus">
                            🗑️
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div class="empty-state">
        <span class="empty-icon">📋</span>
        <p>Belum ada milestone. Klik "Tambah Milestone" untuk menambahkan.</p>
    </div>
    @endif
</div>

<script>
function toggleForm() {
    const form = document.getElementById('milestoneForm');
    const formTitle = document.getElementById('formTitle');
    const formElement = document.getElementById('milestoneFormElement');
    const formMethod = document.getElementById('formMethod');

    if (form.style.display === 'none') {
        // Reset form
        formElement.action = '{{ route('admin.milestones.store') }}';
        formMethod.value = 'POST';
        formTitle.textContent = '➕ Tambah Milestone Baru';
        document.getElementById('year').value = '';
        document.getElementById('title').value = '';
        document.getElementById('description').value = '';
        document.getElementById('sort_order').value = '';
        form.style.display = 'block';
        form.scrollIntoView({ behavior: 'smooth' });
    } else {
        form.style.display = 'none';
    }
}

function editMilestone(id, data) {
    const form = document.getElementById('milestoneForm');
    const formTitle = document.getElementById('formTitle');
    const formElement = document.getElementById('milestoneFormElement');
    const formMethod = document.getElementById('formMethod');

    // Set form untuk edit
    formElement.action = '/admin/milestones/' + id;
    formMethod.value = 'PUT';
    formTitle.textContent = '✏️ Edit Milestone';

    // Fill data
    document.getElementById('year').value = data.year;
    document.getElementById('title').value = data.title;
    document.getElementById('description').value = data.description || '';
    document.getElementById('sort_order').value = data.sort_order || 0;

    form.style.display = 'block';
    form.scrollIntoView({ behavior: 'smooth' });
}
</script>

<style>
.section-title {
    font-family: var(--font-heading);
    font-size: 1.1rem;
    color: var(--cream);
    margin-bottom: 20px;
}
textarea.admin-input {
    resize: vertical;
    min-height: 80px;
}
</style>
@endsection