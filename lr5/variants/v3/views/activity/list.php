<?php
$activities = $activities ?? [];
$userVotes = $userVotes ?? [];
?>

<h1>Активності кінотеатру</h1>
<p>Голосуйте за улюблені активності та фільми благодійного кіно</p>

<div class="form__actions" style="margin-bottom: 20px">
    <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] === 1): ?>
        <a href="index.php?route=activity/create" class="btn">Додати активність</a>
    <?php endif; ?>
</div>

<?php if (empty($activities)): ?>
    <p class="text-muted">Активностей ще немає.</p>
<?php else: ?>
    <div class="activities-grid">
        <?php foreach ($activities as $activity): ?>
            <div class="activity-card">
                <div class="activity-image">
                    <?php if (!empty($activity['image_path'])): ?>
                        <img src="<?= htmlspecialchars($activity['image_path']) ?>" alt="<?= htmlspecialchars($activity['title']) ?>">
                    <?php else: ?>
                        <div class="image-placeholder">
                            <?php 
                                $icons = ['charity' => '❤️', 'kids' => '🎈', 'special' => '🎪'];
                                $icon = $icons[$activity['activity_type']] ?? '🎬';
                            ?>
                            <span class="icon"><?= $icon ?></span>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="activity-content">
                    <h3><?= htmlspecialchars($activity['title']) ?></h3>
                    
                    <?php if (!empty($activity['description'])): ?>
                        <p class="description"><?= htmlspecialchars(substr($activity['description'], 0, 100)) ?>...</p>
                    <?php endif; ?>

                    <div class="activity-type">
                        <?php 
                            $typeNames = [
                                'charity' => '❤️ Благодійна',
                                'kids' => '🎈 Дитяча',
                                'special' => '🎪 Спеціальна'
                            ];
                            $typeName = $typeNames[$activity['activity_type']] ?? htmlspecialchars($activity['activity_type']);
                        ?>
                        <?= $typeName ?>
                    </div>

                    <div class="activity-stats">
                        <p>👍 <?= (int)($activity['voter_count'] ?? 0) ?> люди/людей голосували</p>
                        <p class="vote-count">Всього голосів: <strong><?= (int)($activity['total_votes'] ?? 0) ?></strong></p>
                    </div>

                    <?php if (isset($_SESSION['user_id'])): ?>
                        <form class="vote-form" data-activity-id="<?= (int)$activity['id'] ?>">
                            <input type="hidden" name="activity_id" value="<?= (int)$activity['id'] ?>">
                            <button type="button" class="btn-vote <?= in_array($activity['id'], $userVotes) ? 'voted' : '' ?>">
                                <?= in_array($activity['id'], $userVotes) ? '❤️ Голос знято' : '🤍 Голосувати' ?>
                            </button>
                        </form>
                    <?php else: ?>
                        <p style="font-size: 13px; color: #999;">
                            <a href="index.php?route=auth/login">Увійдіть</a>, щоб голосувати
                        </p>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<style>
.activities-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 20px;
    margin-top: 20px;
}

.activity-card {
    background: white;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    transition: transform 0.3s, box-shadow 0.3s;
    display: flex;
    flex-direction: column;
}

.activity-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 16px rgba(0,0,0,0.15);
}

.activity-image {
    width: 100%;
    height: 200px;
    overflow: hidden;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.activity-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.image-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.image-placeholder .icon {
    font-size: 80px;
}

.activity-content {
    padding: 20px;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.activity-content h3 {
    margin: 0 0 10px 0;
    font-size: 18px;
    color: #333;
}

.description {
    color: #666;
    font-size: 13px;
    line-height: 1.4;
    margin-bottom: 10px;
}

.activity-type {
    display: inline-block;
    padding: 4px 8px;
    background: #e9ecef;
    border-radius: 4px;
    font-size: 12px;
    font-weight: 500;
    margin-bottom: 10px;
}

.activity-stats {
    background: #f9f9f9;
    padding: 10px;
    border-radius: 4px;
    margin-bottom: 15px;
    flex: 1;
}

.activity-stats p {
    margin: 5px 0;
    font-size: 13px;
    color: #666;
}

.vote-count {
    font-weight: 600;
    color: #333 !important;
}

.vote-form {
    margin-top: auto;
}

.btn-vote {
    width: 100%;
    padding: 10px;
    background: #f0f0f0;
    border: 2px solid #ddd;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
    font-weight: 500;
    transition: all 0.3s;
}

.btn-vote:hover {
    background: #ffe0e0;
    border-color: #ff6b6b;
    color: #c92a2a;
}

.btn-vote.voted {
    background: #ffe0e0;
    border-color: #ff6b6b;
    color: #c92a2a;
}

.text-muted {
    color: #999;
    font-style: italic;
}

.btn {
    display: inline-block;
    padding: 10px 20px;
    border-radius: 4px;
    text-decoration: none;
    border: 1px solid #ddd;
    background: white;
    cursor: pointer;
}

.btn:hover {
    background: #f0f0f0;
}

@media (max-width: 768px) {
    .activities-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.vote-form').forEach(form => {
        const btn = form.querySelector('.btn-vote');
        const activityId = form.dataset.activityId;

        btn.addEventListener('click', function(e) {
            e.preventDefault();

            const formData = new FormData();
            formData.append('activity_id', activityId);

            fetch('index.php?route=activity/vote', {
                method: 'POST',
                body: formData
            }).then(r => r.json()).then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Помилка при голосуванні: ' + data.message);
                }
            });
        });
    });
});
</script>
