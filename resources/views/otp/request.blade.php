<form id="otpForm">
    @csrf
    <label>Mobile Number (with country code):</label>
    <input type="tel" name="mobile" placeholder="+65XXXXXXXX" required>
    <button type="submit">Send OTP via WhatsApp</button>
</form>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
document.getElementById('otpForm').addEventListener('submit', function(e) {
    e.preventDefault(); // prevent default form submission

    const formData = new FormData(this);
    axios.post('/otp/request', Object.fromEntries(formData))
        .then(response => {
            alert(response.data.message);
            // Optionally redirect to verify page
            window.location.href = `/otp/verify?mobile=${encodeURIComponent(formData.get('mobile'))}`;
        })
        .catch(error => {
            alert('Failed to send OTP.');
        });
});
</script>
