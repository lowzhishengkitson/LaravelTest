<!-- resources/views/otp/verify.blade.php -->

<label>Enter OTP:</label>
<input type="text" id="otp" required>
<input type="hidden" id="mobile" value="{{ $mobile }}">

<button id="verifyBtn">Verify OTP</button>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
document.getElementById('verifyBtn').addEventListener('click', function() {
    const otp = document.getElementById('otp').value;
    const mobile = document.getElementById('mobile').value;

    axios.post('/otp/verify', { mobile, otp })
        .then(response => {
            console.log(response.data.token);
            // Save Sanctum token in localStorage
            localStorage.setItem('auth_token', response.data.token);

            alert('OTP verified! You are logged in.');
            alert(response.data.token);

            // Optional: Redirect or fetch protected data
            window.location.href = '/dashboard'; // or wherever
        })
        .catch(error => {
            alert('Invalid OTP or error occurred.');
            console.error(error.response.data);
        });
});
</script>
