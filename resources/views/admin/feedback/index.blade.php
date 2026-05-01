@extends('admin.layout')
@section('title', 'Feedback Pelanggan')
@section('page_title', 'Feedback Pelanggan')

@section('content')
<div class="admin-toolbar">
    <div class="toolbar-info">
        <span class="feedback-badge {{ $feedbacks->where('is_read', false)->count() > 0 ? 'unread' : '' }}">
            {{ $feedbacks->where('is_read', false)->count() }} belum dibaca
        </span>
        <span class="total-badge">Total: {{ $feedbacks->count() }}</span>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success">
    <span class="alert-icon">✅</span>
    {{ session('success') }}
</div>
@endif

<div class="admin-card">
    @forelse($feedbacks as $feedback)
    <div class="feedback-card {{ !$feedback->is_read ? 'unread' : '' }}">
        <div class="feedback-header">
            <div class="feedback-info">
                <h3 class="feedback-name">{{ $feedback->name }}</h3>
                <span class="feedback-date">{{ $feedback->created_at->format('d M Y, H:i') }}</span>
            </div>
            <div class="feedback-actions">
                @if(!$feedback->is_read)
                <form action="{{ route('admin.feedback.read', $feedback) }}" method="POST" style="display:inline">
                    @csrf
                    <button type="submit" class="action-btn read" title="Tandai sudah dibaca">✓</button>
                </form>
                @endif
                <form action="{{ route('admin.feedback.destroy', $feedback) }}" method="POST" style="display:inline" onsubmit="return confirm('Yakin hapus feedback dari {{ $feedback->name }}?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="action-btn delete" title="Hapus">🗑️</button>
                </form>
            </div>
        </div>
        <div class="feedback-details">
            <span class="feedback-email">✉️ {{ $feedback->email }}</span>
            @if($feedback->phone)
            <span class="feedback-phone">📞 {{ $feedback->phone }}</span>
            @endif
        </div>
        <div class="feedback-message">
            <p>{{ $feedback->message }}</p>
        </div>
    </div>
    @empty
    <div class="empty-state">
        <span class="empty-icon">📬</span>
        <p>Belum ada feedback dari pelanggan</p>
    </div>
    @endforelse
</div>
@endsection

<style>
.feedback-badge {
    padding: 6px 14px;
    background: rgba(39, 174, 96, 0.15);
    color: #27ae60;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 600;
}
.feedback-badge.unread {
    background: rgba(200, 149, 108, 0.2);
    color: var(--gold);
}
.total-badge {
    padding: 6px 14px;
    background: rgba(200, 149, 108, 0.1);
    color: var(--text-muted);
    border-radius: 20px;
    font-size: 0.85rem;
    margin-left: 8px;
}
.alert-success {
    padding: 16px;
    background: rgba(39, 174, 96, 0.1);
    border: 1px solid rgba(39, 174, 96, 0.3);
    border-radius: 8px;
    color: #27ae60;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 8px;
}
.feedback-card {
    background: var(--bg-card);
    border: 1px solid rgba(200, 149, 108, 0.1);
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 16px;
    transition: var(--transition);
}
.feedback-card.unread {
    border-color: rgba(200, 149, 108, 0.3);
    background: rgba(200, 149, 108, 0.03);
}
.feedback-card:hover {
    border-color: rgba(200, 149, 108, 0.2);
}
.feedback-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 12px;
}
.feedback-name {
    font-family: var(--font-heading);
    font-size: 1.1rem;
    color: var(--cream);
    margin: 0 0 4px;
}
.feedback-date {
    font-size: 0.8rem;
    color: var(--text-muted);
}
.feedback-actions {
    display: flex;
    gap: 8px;
}
.action-btn.read {
    background: rgba(39, 174, 96, 0.15);
    color: #27ae60;
    border: none;
    padding: 8px 12px;
    border-radius: 6px;
    cursor: pointer;
    font-size: 0.9rem;
    transition: var(--transition);
}
.action-btn.read:hover {
    background: rgba(39, 174, 96, 0.25);
}
.feedback-details {
    display: flex;
    gap: 16px;
    margin-bottom: 12px;
    flex-wrap: wrap;
}
.feedback-email, .feedback-phone {
    font-size: 0.85rem;
    color: var(--text-muted);
}
.feedback-message {
    background: rgba(200, 149, 108, 0.05);
    border-radius: 8px;
    padding: 14px 16px;
}
.feedback-message p {
    color: var(--text-secondary);
    font-size: 0.9rem;
    line-height: 1.6;
    margin: 0;
}
.empty-state {
    text-align: center;
    padding: 60px 20px;
    color: var(--text-muted);
}
.empty-icon {
    font-size: 3rem;
    display: block;
    margin-bottom: 12px;
}
</style>