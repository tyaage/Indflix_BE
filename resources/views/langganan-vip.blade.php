<h2>Beli Langganan VIP</h2>

<form method="POST" action="/langganan-vip">
    @csrf

    <label>
        <input type="radio" name="duration" value="7"> 1 Minggu
    </label><br>

    <label>
        <input type="radio" name="duration" value="30"> 1 Bulan
    </label><br>

    <label>
        <input type="radio" name="duration" value="60"> 2 Bulan
    </label><br>

    <label>
        <input type="radio" name="duration" value="90"> 3 Bulan
    </label><br>

    <button type="submit">Beli</button>
</form>
