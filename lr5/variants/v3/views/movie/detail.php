<?php
$movie = $movie ?? [];
$comments = $comments ?? [];
$reactions = $reactions ?? [];
$userReaction = $userReaction ?? null;
$userComment = $userComment ?? null;
$polls = $polls ?? [];
$screenings = $screenings ?? [];
?>

<div class="movie-detail">
    <div class="movie-header">
        <div class="movie-poster-large">
            <?php if (!empty($movie['poster_image'])): ?>
                <img src="<?= htmlspecialchars($movie['poster_image']) ?>" alt="<?= htmlspecialchars($movie['title']) ?>">
            <?php else: ?>
                <div class="poster-placeholder-large">🎬</div>
            <?php endif; ?>
        </div>
        
        <div class="movie-details-info">
            <h1><?= htmlspecialchars($movie['title']) ?></h1>
            
            <div class="movie-meta">
                <p><strong>Режисер:</strong> <?= htmlspecialchars($movie['director']) ?></p>
                <p><strong>Жанр:</strong> <?= htmlspecialchars($movie['genre']) ?></p>
                <p><strong>Рік:</strong> <?= (int)$movie['year'] ?></p>
                <p><strong>Тривалість:</strong> <?= (int)$movie['duration_min'] ?> хвилин</p>
            </div>

            <?php if (!empty($movie['description'])): ?>
                <div class="movie-description">
                    <p><?= nl2br(htmlspecialchars($movie['description'])) ?></p>
                </div>
            <?php endif; ?>

            <!-- Reactions -->
            <div class="reactions-section">
                <h3>Реакції</h3>
                <div class="reactions-buttons">
                    <form method="POST" action="index.php?route=movie/add_reaction" class="reaction-form" data-movie-id="<?= (int)$movie['id'] ?>">
                        <input type="hidden" name="movie_id" value="<?= (int)$movie['id'] ?>">
                        <button type="button" class="reaction-btn like-btn" data-type="like">
                            👍 Мне нравится 
                            <span class="reaction-count"><?= (int)($reactions['like'] ?? 0) ?></span>
                        </button>
                        <button type="button" class="reaction-btn dislike-btn" data-type="dislike">
                            👎 Не нравится 
                            <span class="reaction-count"><?= (int)($reactions['dislike'] ?? 0) ?></span>
                        </button>
                    </form>
                    <?php if ($userReaction): ?>
                        <p class="user-reaction">Ваша реакция: <strong><?= $userReaction === 'like' ? '👍 Like' : '👎 Dislike' ?></strong></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <div class="movie-screenings-sidebar">
            <h3>Сеанси</h3>
            <?php
                $byDate = [];
                foreach ($screenings as $s) {
                    $d = substr($s['screening_datetime'], 0, 10);
                    $byDate[$d][] = $s;
                }
                $dates = array_keys($byDate);
            ?>
            <?php if (empty($dates)): ?>
                <p class="text-muted">Поки що немає сеансів.</p>
            <?php else: ?>
                <label for="screening_date">Оберіть день:</label>
                <select id="screening_date" class="form__select">
                    <?php foreach ($dates as $i => $d): ?>
                        <option value="<?= htmlspecialchars($d) ?>" <?= $i === 0 ? 'selected' : '' ?>><?= date('d.m.Y (D)', strtotime($d)) ?></option>
                    <?php endforeach; ?>
                </select>

                <div id="times_list" style="margin-top:12px;">
                    <!-- times inserted by JS -->
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Polls -->
    <?php if (!empty($polls)): ?>
        <div class="polls-section">
            <h3>Голосування</h3>
            <?php foreach ($polls as $poll): ?>
                <div class="poll-card">
                    <h4><?= htmlspecialchars($poll['question']) ?></h4>
                    <div class="poll-options">
                        <?php foreach ($poll['options'] as $option): ?>
                            <div class="poll-option">
                                <div class="option-row">
                                    <label class="poll-label">
                                        <input type="radio" name="poll_<?= (int)$poll['id'] ?>" 
                                               value="<?= (int)$option['id'] ?>" 
                                               class="poll-input"
                                               data-poll-id="<?= (int)$poll['id'] ?>"
                                               data-option-id="<?= (int)$option['id'] ?>"
                                               <?= $poll['user_voted'] && $poll['user_vote_option'] == $option['id'] ? 'checked' : '' ?>>
                                        <span><?= htmlspecialchars($option['option_text']) ?></span>
                                    </label>
                                    <span class="vote-count"><?= (int)$option['vote_count'] ?> голосів</span>
                                </div>
                                <?php if ($poll['total_votes'] > 0): ?>
                                    <div class="progress-bar">
                                        <div class="progress" style="width: <?= ($option['vote_count'] / max(1, $poll['total_votes']) * 100) ?>%"></div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <p class="poll-total">Всього голосів: <?= (int)$poll['total_votes'] ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- Comments Section -->
    <div class="comments-section">
        <h3>Коментарі (<?= count($comments) ?>)</h3>

        <?php if (isset($_SESSION['user_id'])): ?>
            <div class="comment-form">
                <form method="POST" action="index.php?route=movie/add_comment">
                    <input type="hidden" name="movie_id" value="<?= (int)$movie['id'] ?>">
                    
                    <div class="form-group">
                        <label for="rating">Рейтинг:</label>
                        <select id="rating" name="rating" class="form-control">
                            <?php for ($i = 1; $i <= 10; $i++): ?>
                                <option value="<?= $i ?>" <?= $userComment && $userComment['rating'] == $i ? 'selected' : '' ?>>
                                    <?= $i ?>/10
                                </option>
                            <?php endfor; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="comment">Ваш коментар:</label>
                        <textarea id="comment" name="comment" class="form-control" rows="4" required><?= htmlspecialchars($userComment['comment'] ?? '') ?></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Залишити коментар</button>
                </form>
            </div>
        <?php else: ?>
            <p><a href="index.php?route=auth/login">Увійдіть</a>, щоб залишити коментар</p>
        <?php endif; ?>

        <!-- Comments List -->
        <?php if (empty($comments)): ?>
            <p class="text-muted">Коментарів ще немає.</p>
        <?php else: ?>
            <div class="comments-list">
                <?php foreach ($comments as $comment): ?>
                    <div class="comment-item">
                        <div class="comment-header">
                            <strong><?= htmlspecialchars($comment['first_name'] . ' ' . $comment['last_name']) ?></strong>
                            <span class="comment-date"><?= date('d.m.Y H:i', strtotime($comment['created_at'])) ?></span>
                            <span class="comment-rating">⭐ <?= (int)$comment['rating'] ?>/10</span>
                        </div>
                        <p class="comment-text"><?= nl2br(htmlspecialchars($comment['comment'])) ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <div style="margin-top: 30px;">
        <a href="index.php?route=movie/gallery" class="btn">← Повернутися до галереї</a>
    </div>
</div>

<style>
.movie-detail {
    max-width: 1000px;
    margin: 0 auto;
}

.movie-header {
    display: grid;
    grid-template-columns: 250px 1fr 300px;
    gap: 30px;
    margin-bottom: 40px;
    padding-bottom: 20px;
    border-bottom: 2px solid #e9ecef;
}

.movie-poster-large {
    width: 100%;
}

.movie-poster-large img {
    width: 100%;
    height: auto;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.poster-placeholder-large {
    width: 100%;
    aspect-ratio: 2/3;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 60px;
    border-radius: 8px;
    color: white;
}

.movie-details-info h1 {
    margin-top: 0;
    margin-bottom: 15px;
}

.movie-meta {
    background: #f9f9f9;
    padding: 15px;
    border-radius: 6px;
    margin-bottom: 15px;
}

.movie-meta p {
    margin: 8px 0;
    font-size: 14px;
}

.movie-description {
    line-height: 1.6;
    margin-bottom: 20px;
}

.reactions-section,
.screenings-section,
.polls-section,
.comments-section {
    margin: 30px 0;
    padding: 20px;
    background: #f9f9f9;
    border-radius: 8px;
}

.reactions-buttons {
    display: flex;
    gap: 15px;
    margin: 15px 0;
    flex-wrap: wrap;
}

.reaction-form {
    display: contents;
}

    .reaction-btn {
    padding: 8px 16px;
    border: 2px solid #ddd;
    border-radius: 20px;
    cursor: pointer;
    font-size: 14px;
    transition: all 0.3s;
    background: inherit;
    color: inherit;
}

    .reaction-btn:hover {
    border-color: #667eea;
    background: rgba(255,255,255,0.06);
}

.reaction-btn.active {
    border-color: #667eea;
    background: #667eea;
    color: white;
}

.reaction-count {
    font-weight: bold;
    margin-left: 5px;
}

    .user-reaction {
    font-size: 13px;
    color: inherit;
    margin: 10px 0 0 0;
}

.screenings-list {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 15px;
    margin-top: 15px;
}

    .screening-card {
    background: inherit;
    padding: 15px;
    border-radius: 6px;
    border: 1px solid rgba(255,255,255,0.04);
    color: inherit;
}

.screening-card p {
    margin: 8px 0;
    font-size: 14px;
}

.btn-success {
    background: #28a745;
    color: white;
    padding: 8px 12px;
    display: inline-block;
    text-decoration: none;
    border-radius: 4px;
    margin-top: 10px;
    font-size: 13px;
}

.btn-success:hover {
    background: #218838;
}

    .polls-section {
    background: inherit;
    border-left: 4px solid #667eea;
    color: inherit;
}

.poll-card {
    background: #f9f9f9;
    padding: 15px;
    border-radius: 6px;
    margin-bottom: 15px;
}

.poll-card h4 {
    margin-top: 0;
}

.poll-options {
    display: flex;
    flex-direction: column;
    gap: 12px;
    margin: 15px 0;
}

    .poll-option {
    background: inherit;
    padding: 10px;
    border-radius: 4px;
    border: 1px solid rgba(255,255,255,0.04);
    color: inherit;
}

.option-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 8px;
}

.poll-label {
    display: flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
    flex: 1;
}

.poll-input {
    cursor: pointer;
}

.vote-count {
    font-size: 12px;
    color: #888;
    white-space: nowrap;
}

.progress-bar {
    width: 100%;
    height: 6px;
    background: #e9ecef;
    border-radius: 3px;
    overflow: hidden;
}

.progress {
    height: 100%;
    background: linear-gradient(90deg, #667eea, #764ba2);
    transition: width 0.3s;
}

.poll-total {
    font-size: 12px;
    color: #888;
    margin-top: 8px;
}

    .comment-form {
    background: inherit;
    padding: 20px;
    border-radius: 6px;
    margin-bottom: 20px;
    border: 1px solid rgba(255,255,255,0.04);
}

.form-group {
    margin-bottom: 15px;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: 500;
}

.form-control {
    width: 100%;
    padding: 8px 12px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-family: inherit;
    font-size: 13px;
}

.form-control:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 2px rgba(102, 126, 234, 0.1);
}

.btn-primary {
    background: #667eea;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
}

.btn-primary:hover {
    background: #5568d3;
}

.comments-list {
    margin-top: 20px;
    display: flex;
    flex-direction: column;
    gap: 15px;
}

    .comment-item {
    background: inherit;
    padding: 15px;
    border-radius: 6px;
    border-left: 3px solid #667eea;
    border: 1px solid rgba(255,255,255,0.04);
}

    .comment-header {
    display: flex;
    gap: 15px;
    margin-bottom: 10px;
    flex-wrap: wrap;
    align-items: center;
    font-size: 13px;
    color: inherit;
}

.comment-date,
.comment-rating {
    margin-left: auto;
}

    .comment-text {
    margin: 0;
    line-height: 1.5;
    color: inherit;
}

.text-muted {
    color: #999;
    font-style: italic;
}

@media (max-width: 768px) {
    .movie-header {
        grid-template-columns: 1fr;
    }

    .screenings-list,
    .reactions-buttons {
        grid-template-columns: 1fr;
    }

    .option-row {
        flex-direction: column;
        align-items: flex-start;
    }

    .vote-count {
        margin-top: 5px;
    }
}
</style>

<script>
// Populate times list based on selected date
document.addEventListener('DOMContentLoaded', function(){
    const byDate = {};
    <?php foreach ($screenings as $s): $d = substr($s['screening_datetime'],0,10); $time = substr($s['screening_datetime'],11,5); ?>
        if (!byDate['<?= $d ?>']) byDate['<?= $d ?>'] = [];
        byDate['<?= $d ?>'].push({id: <?= (int)$s['id'] ?>, time: '<?= $time ?>', price: '<?= number_format($s['price_per_ticket'],2) ?>', hall: '<?= htmlspecialchars($s['hall_name']) ?>'});
    <?php endforeach; ?>

    const dateSelect = document.getElementById('screening_date');
    const timesList = document.getElementById('times_list');

    function renderTimes(day) {
        timesList.innerHTML = '';
        const arr = byDate[day] || [];
        arr.forEach(function(s){
            const div = document.createElement('div');
            div.className = 'screening-card';
            div.innerHTML = '<p><strong>Зала:</strong> '+s.hall+'</p>'+
                            '<p><strong>Час:</strong> '+s.time+'</p>'+
                            '<p><strong>Ціна:</strong> ₴'+s.price+'</p>'+
                            (<?= isset($_SESSION['user_id']) ? 'true' : 'false' ?> ? '<a class="btn btn-success" href="index.php?route=movie/buy_ticket&screening_id='+s.id+'">Купити квитки</a>' : '<a class="btn" href="index.php?route=auth/login">Увійдіть для покупки</a>');
            timesList.appendChild(div);
        });
    }

    if (dateSelect) {
        renderTimes(dateSelect.value);
        dateSelect.addEventListener('change', function(){ renderTimes(this.value); });
    }
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Reaction buttons
    document.querySelectorAll('.reaction-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const form = this.closest('.reaction-form');
            const type = this.dataset.type;
            const movieId = form.dataset.movieId;

            if (!<?= isset($_SESSION['user_id']) ? 'true' : 'false' ?>) {
                alert('Будь ласка, увійдіть для додавання реакції');
                return;
            }

            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'reaction_type';
            input.value = type;
            form.appendChild(input);

            fetch('index.php?route=movie/add_reaction', {
                method: 'POST',
                body: new FormData(form)
            }).then(r => r.json()).then(data => {
                if (data.success) {
                    location.reload();
                }
            });
        });
    });

    // Poll voting
    document.querySelectorAll('.poll-input').forEach(input => {
        input.addEventListener('change', function() {
            const pollId = this.dataset.pollId;
            const optionId = this.dataset.optionId;

            if (!<?= isset($_SESSION['user_id']) ? 'true' : 'false' ?>) {
                alert('Будь ласка, увійдіть для голосування');
                this.checked = false;
                return;
            }

            const formData = new FormData();
            formData.append('poll_id', pollId);
            formData.append('option_id', optionId);

            fetch('index.php?route=movie/vote_poll', {
                method: 'POST',
                body: formData
            }).then(r => r.json()).then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Помилка при голосуванні: ' + data.message);
                    this.checked = false;
                }
            });
        });
    });
});
</script>
