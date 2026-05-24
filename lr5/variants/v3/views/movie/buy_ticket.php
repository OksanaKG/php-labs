<?php
$screening = $screening ?? [];
$seats = $seats ?? [];
$selectedSeats = $selectedSeats ?? [];
$errors = $errors ?? [];
// poster image
$poster = $screening['poster_image'] ?? '';
?>

<h1>Купити квитки: <?= htmlspecialchars($screening['title'] ?? '') ?></h1>
<form method="POST" action="index.php?route=movie/buy_ticket&screening_id=<?= (int)$screening['id'] ?>" id="ticketForm">
<div class="ticket-purchase-container">
    <div class="purchase-column" style="flex:1;display:flex;flex-direction:column;gap:18px;">
        <div class="info-row" style="display:flex;gap:12px;align-items:flex-start;">
            <div class="poster-left" style="flex:0 0 180px;">
                <?php if (!empty($poster)): ?>
                    <img src="<?= htmlspecialchars($poster) ?>" alt="poster" style="width:100%;height:auto;border-radius:8px;object-fit:cover;">
                <?php else: ?>
                    <div style="width:100%;height:260px;border-radius:8px;background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);display:flex;align-items:center;justify-content:center;color:#fff;font-size:40px;">🎬</div>
                <?php endif; ?>
            </div>
            <div class="screening-info" style="flex:1;">
                <h3>Інформація про сеанс</h3>
                <p><strong>Фільм:</strong> <?= htmlspecialchars($screening['title'] ?? '') ?></p>
                <p><strong>Зала:</strong> <?= htmlspecialchars($screening['hall_name'] ?? '') ?></p>
                <p><strong>Час:</strong> <?= htmlspecialchars($screening['screening_datetime'] ?? '') ?></p>
                <p><strong>Ціна за квиток:</strong> <span style="font-size: 18px; font-weight: bold; color: #28a745;">₴<?= number_format($screening['price_per_ticket'] ?? 0, 2) ?></span></p>
            </div>
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

        <div class="hall-layout">
            <h3>Оберіть місця</h3>
            <div class="screen">
                <div class="screen-label">ЕКРАН</div>
            </div>

            <div class="seats-grid" id="seatsContainer">
                <?php
                // Group seats by row
                $rows = [];
                foreach ($seats as $s) {
                    $rows[$s['row_num']][] = $s;
                }
                ksort($rows, SORT_NUMERIC);
                $maxSeats = 14; // fixed 14 seats per row

                foreach ($rows as $rowNum => $rowSeats):
                    $count = count($rowSeats);
                    $left = (int)floor(($maxSeats - $count) / 2);
                ?>
                    <div class="row-wrap" style="display:flex;align-items:center;gap:12px;">
                        <div class="row-label">Ряд <?= (int)$rowNum ?></div>
                        <div class="seats-row" style="grid-template-columns: repeat(<?= $maxSeats ?>, 44px);">
                            <?php for ($i=0;$i<$left;$i++): ?>
                                <div class="seat placeholder" aria-hidden="true"></div>
                            <?php endfor; ?>

                            <?php foreach ($rowSeats as $seat):
                                $isBooked = (int)$seat['is_booked'] > 0;
                                $isSelected = in_array($seat['id'], array_values((array)$selectedSeats));
                                $seatClass = 'seat';
                                if ($isBooked) $seatClass .= ' booked';
                                if ($isSelected) $seatClass .= ' selected';
                            ?>
                                <label class="<?= $seatClass ?>">
                                    <input type="checkbox" name="seats[]" value="<?= (int)$seat['id'] ?>" 
                                           <?= $isBooked ? 'disabled' : '' ?>
                                           <?= $isSelected ? 'checked' : '' ?>>
                                    <span class="seat-number"><?= (int)$seat['seat_num'] ?></span>
                                </label>
                            <?php endforeach; ?>

                            <?php for ($i=0;$i<($maxSeats - $left - $count);$i++): ?>
                                <div class="seat placeholder" aria-hidden="true"></div>
                            <?php endfor; ?>
                        </div>
                    </div>
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

    </div>
    <div class="sidebar-column" style="flex:0 0 380px;">
        <div class="total-section">
            <h3>Загалом</h3>
            <p>Вибрано місць: <span id="seatCount">0</span></p>
            <p>Список місць: <span id="selectedSeats">—</span></p>
            <p>Сума: <span id="totalPrice" style="font-size: 20px; font-weight: bold; color: #28a745;">₴0.00</span></p>
            <button type="submit" class="btn btn-success btn-large">Завершити покупку</button>
            <a href="index.php?route=movie/detail&id=<?= (int)$screening['movie_id'] ?>" class="btn">Скасувати</a>
        </div>
    </div>
</div>
</form>

<style>
.ticket-purchase-container {
    /* layout controlled by global css, fallback */
    padding: 8px;
}

.screening-info {
    background: inherit;
    padding: 20px;
    border-radius: 8px;
    margin-bottom: 18px;
    color: inherit;
    border: 1px solid rgba(230, 230, 230, 0.3);
}

.screening-info p {
    margin: 8px 0;
    font-size: 15px;
}

.hall-layout {
    background: inherit;
    padding: 20px;
    border-radius: 8px;
    margin-bottom: 18px;
    border: 1px solid rgba(230, 230, 230, 0.3);
    color: inherit;
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

.seats-grid { margin-bottom: 20px; }

.row-label {
    min-width: 60px;
    text-align: right;
    font-weight: 500;
    color: #666;
    font-size: 13px;
}

.row-wrap { width: 100%; display:flex; align-items:center; gap:12px; }

.seats-row { display: grid; gap:8px; align-items:center; justify-content:center; }

.seat:hover:not(.booked) {
    background: #667eea;
    border-color: #667eea;
    color: white;
    transform: scale(1.1);
}

.seat input {
    display: none;
}

.seat-number { font-size: 12px; color: var(--seat-text); font-weight:700; text-shadow: 0 1px 2px rgba(0,0,0,0.6); }
body.bg-light-theme .seat-number { text-shadow: none; }

.seat.selected {
    background: #667eea;
    border-color: #667eea;
    color: white;
    box-shadow: 0 0 8px rgba(102, 126, 234, 0.4);
}

.seat.booked {
    background: #666;
    border-color: #555;
    cursor: not-allowed;
    color: #fff;
    opacity: 1;
}

.legend {
    display: flex;
    gap: 18px;
    justify-content: center;
    flex-wrap: wrap;
    padding-top: 12px;
    border-top: 1px solid rgba(230, 230, 230, 0.3);
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
    background: inherit;
    padding: 20px;
    border-radius: 8px;
    text-align: center;
    color: inherit;
    border: 1px solid rgba(230, 230, 230, 0.3);
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
        const selectedNames = selected.map(cb => {
            const label = cb.closest('label');
            const num = label ? (label.querySelector('.seat-number') ? label.querySelector('.seat-number').textContent.trim() : cb.value) : cb.value;
            // Try to read row from nearest .row-label sibling
            const rowDiv = label ? label.parentElement.querySelector('.row-label') : null;
            const row = rowDiv ? rowDiv.textContent.replace('Ряд','').trim() : '';
            return (row ? ('Р' + row + '-') : '') + num;
        });
        document.getElementById('selectedSeats').textContent = selectedNames.length ? selectedNames.join(', ') : '—';
        submitBtn.disabled = count === 0;
    }

    // toggle selected class and update totals on change
    checkboxes.forEach(checkbox => {
        const label = checkbox.closest('label');
        if (checkbox.checked) label && label.classList.add('selected');
        checkbox.addEventListener('change', function() {
            if (checkbox.checked) label && label.classList.add('selected'); else label && label.classList.remove('selected');
            updateTotals();
        });
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
