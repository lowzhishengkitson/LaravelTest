<form method="POST" action="/otp/request">
    @csrf
    <label>Mobile Number (with country code):</label>
    <input type="tel" name="mobile" placeholder="+65XXXXXXXX" required>
    <button type="submit">Send OTP via WhatsApp</button>
</form>
