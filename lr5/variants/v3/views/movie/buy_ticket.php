<?php
$screening = $screening ?? [];
$seats = $seats ?? [];
$selectedSeats = $selectedSeats ?? [];
$errors = $errors ?? [];
?>

<h1>Купити квитки: <?= htmlspecialchars($screening['title'] ?? '') ?></h1>

<div class="ticket-purchase-container">
    <div class="screening-info">
        <h3>Інформація про сеанс</h3>
        <p><strong>Фільм:</strong> <?= htmlspecialchars($screening['title'] ?? '') ?></p>
        <p><strong>Зала:</strong> <?= htmlspecialchars($screening['hall_name'] ?? '') ?></p>
        <p><strong>Час:</strong> <?= htmlspecialchars($screening['screening_datetime'] ?? '') ?></p>
        <p><strong>Ціна за квиток:</strong> <span style="font-size: 18px; font-weight: bold; color: #28a745;">₴<?= number_format($screening['price_per_ticket'] ?? 0, 2) ?></span></p>
    </div>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" action="index.php?route=movie/buy_ticket&screening_id=<?= (int)$screening['id'] ?>" id="ticketForm">
        <div class="hall-layout">
            <h3>Оберіть місця</h3>
            <div class="screen">
                <div class="screen-label">ЕКРАН</div>
            </div>

            <div class="seats-grid" id="seatsContainer">
                <?php 
                $currentRow = 0;
                $rowHtml = '<div class="seats-row">';
                
                foreach ($seats as $seat): 
                    if ($seat['row_num'] != $currentRow):
                        if ($currentRow > 0):
                            $rowHtml .= '</div>';
                            echo $rowHtml;
                        endif;
                        $rowHtml = '<div class="seats-row"><div class="row-label">Ряд ' . $seat['row_num'] . '</div>';
                        $currentRow = $seat['row_num'];
                    endif;
                    
                    $isBooked = (int)$seat['is_booked'] > 0;
                    $isSelected = in_array($seat['id'], array_values((array)$selectedSeats));
                    $seatClass = 'seat';
                    if ($isBooked) {
                        $seatClass .= ' booked';
                    }
                    if ($isSelected) {
                        $seatClass .= ' selected';
                    }
                ?>
                    <label class="<?= $seatClass ?>">
                        <input type="checkbox" name="seats[]" value="<?= (int)$seat['id'] ?>" 
                               <?= $isBooked ? 'disabled' : '' ?>
                               <?= $isSelected ? 'checked' : '' ?>>
                        <span class="seat-number"><?= (int)$seat['seat_num'] ?></span>
                    </label>
                <?php endforeach; ?>
                </div>
            </div>

            <div class="legend">
                <div class="legend-item">
                    <div class="seat legend-seat"></div>
                    <span>Вільне місце</span>
                </div>
                <div class="legend-item">
                    <div class="seat selected"></div>
                    <span>Обране місце</span>
                </div>
                <div class="legend-item">
                    <div class="seat booked"></div>
                    <span>Забронене місце</span>
                </div>
            </div>
        </div>

        <div class="total-section">
            <h3>Загалом</h3>
            <p>Вибрано місць: <span id="seatCount">0</span></p>
            <p>Сума: <span id="totalPrice" style="font-size: 20px; font-weight: bold; color: #28a745;">₴0.00</span></p>
            <button type="submit" class="btn btn-success btn-large">Завершити покупку</button>
            <a href="index.php?route=movie/detail&id=<?= (int)$screening['movie_id'] ?>" class="btn">Скасувати</a>
        </div>
    </form>
</div>

<style>
.ticket-purchase-container {
    max-width: 1000px;
    margin: 0 auto;
}

.screening-info {
    background: #f9f9f9;
    padding: 20px;
    border-radius: 8px;
    margin-bottom: 30px;
}

.screening-info p {
    margin: 8px 0;
    font-size: 15px;
}

.hall-layout {
    background: white;
    padding: 30px;
    border-radius: 8px;
    margin-bottom: 30px;
    border: 1px solid #ddd;
}

.screen {
    text-align: center;
    margin-bottom: 40px;
}

.screen-label {
    display: inline-block;
    width: 100%;
    padding: 15px;
    background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
    color: white;
    font-weight: bold;
    font-size: 16px;
    border-radius: 4px;
    letter-spacing: 2px;
}

.seats-grid {
    display: flex;
    flex-direction: column;
    gap: 15px;
    margin-bottom: 30px;
}

.seats-row {
    display: flex;
    gap: 8px;
    align-items: center;
    justify-content: center;
}

.row-label {
    min-width: 60px;
    text-align: right;
    font-weight: 500;
    color: #666;
    font-size: 13px;
}

.seat {
    position: relative;
    width: 30px;
    height: 30px;
    background: #e9ecef;
    border: 1px solid #ccc;
    border-radius: 4px;
    cursor: pointer;
    transition: all 0.2s;
    display: flex;
    align-items: center;
    justify-content: center;
}

.seat:hover:not(.booked) {
    background: #667eea;
    border-color: #667eea;
    color: white;
    transform: scale(1.1);
}

.seat input {
    display: none;
}

.seat-number {
    font-size: 11px;
    font-weight: 600;
    color: inherit;
}

.seat.selected {
    background: #667eea;
    border-color: #667eea;
    color: white;
    box-shadow: 0 0 8px rgba(102, 126, 234, 0.4);
}

.seat.booked {
    background: #ccc;
    border-color: #999;
    cursor: not-allowed;
    opacity: 0.5;
}

.legend {
    display: flex;
    gap: 30px;
    justify-content: center;
    flex-wrap: wrap;
    padding-top: 20px;
    border-top: 1px solid #ddd;
}

.legend-item {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
}

.legend-seat {
    width: 24px;
    height: 24px;
    border-radius: 3px;
}

.legend-item:nth-child(1) .legend-seat {
    background: #e9ecef;
    border: 1px solid #ccc;
}

.legend-item:nth-child(2) .legend-seat {
    background: #667eea;
    border: 1px solid #667eea;
}

.legend-item:nth-child(3) .legend-seat {
    background: #ccc;
    border: 1px solid #999;
}

.total-section {
    background: #f9f9f9;
    padding: 20px;
    border-radius: 8px;
    text-align: center;
}

.total-section h3 {
    margin-top: 0;
}

.total-section p {
    font-size: 16px;
    margin: 10px 0;
}

.btn-success {
    background: #28a745;
    color: white;
    padding: 12px 30px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 15px;
    margin-right: 10px;
    display: inline-block;
    text-decoration: none;
    font-weight: 500;
}

.btn-success:hover {
    background: #218838;
}

.btn-success:disabled {
    background: #ccc;
    cursor: not-allowed;
}

.btn-large {
    padding: 14px 40px;
    font-size: 16px;
}

.alert {
    padding: 15px;
    margin-bottom: 20px;
    border-radius: 4px;
}

.alert-danger {
    background: #f8d7da;
    border: 1px solid #f5c6cb;
    color: #721c24;
    border-radius: 4px;
}

.alert-danger ul {
    margin: 0;
    padding-left: 20px;
}

.alert-danger li {
    margin: 5px 0;
}

@media (max-width: 768px) {
    .hall-layout {
        padding: 15px;
    }

    .seats-row {
        gap: 5px;
    }

    .seat {
        width: 26px;
        height: 26px;
        font-size: 10px;
    }

    .legend {
        gap: 15px;
    }

    .btn-success,
    .btn {
        width: 100%;
        margin: 5px 0;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('ticketForm');
    const checkboxes = form.querySelectorAll('input[name="seats[]"]:not(:disabled)');
    const seatCountSpan = document.getElementById('seatCount');
    const totalPriceSpan = document.getElementById('totalPrice');
    const pricePerTicket = <?= (float)($screening['price_per_ticket'] ?? 0) ?>;
    const submitBtn = form.querySelector('button[type="submit"]');

    function updateTotals() {
        const selected = Array.from(checkboxes).filter(cb => cb.checked);
        const count = selected.length;
        const total = count * pricePerTicket;

        seatCountSpan.textContent = count;
        totalPriceSpan.textContent = '₴' + total.toFixed(2);
        submitBtn.disabled = count === 0;
    }

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateTotals);
    });

    updateTotals();

    form.addEventListener('submit', function(e) {
        const selected = Array.from(checkboxes).filter(cb => cb.checked);
        if (selected.length === 0) {
            e.preventDefault();
            alert('Будь ласка, оберіть щонайменше одне місце');
        }
    });
});
</script>
