function showSection(sectionID) {
    document.querySelectorAll('.content').forEach(s => s.style.display = 'none');
    document.getElementById('home').style.display = 'none';
    const active = document.getElementById(sectionID);
    if(active) active.style.display = 'block';
}
function hideContent() {
    document.querySelectorAll('.content').forEach(s => s.style.display = 'none');
    document.getElementById('home').style.display = 'block';
}
function clearFields() {
    document.querySelectorAll('input').forEach(input => input.value = '');
}
window.onload = function() {
    const params = new URLSearchParams(window.location.search);
    if (params.get('status') === 'success') {
        const toast = document.getElementById('success-toast');
        toast.style.display = 'block';
        setTimeout(() => { toast.style.display = 'none'; }, 3000);
    }
}
