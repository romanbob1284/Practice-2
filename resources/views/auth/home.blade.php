<script>
    localStorage.getItem('jwt') ? window.location.href = '/dashboard' : window.location.href = '/login';
</script>