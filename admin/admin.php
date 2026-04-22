<?php

declare(strict_types=1);

require __DIR__ . '/bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = postString('action');

    if ($action === 'save_skill') {
        $id = (int) ($_POST['id'] ?? 0);
        $name = postString('name');
        $sortOrder = (int) ($_POST['sort_order'] ?? 0);

        if ($name !== '') {
            if ($id > 0) {
                $stmt = db()->prepare('UPDATE skills SET name = ?, sort_order = ? WHERE id = ?');
                $stmt->execute([$name, $sortOrder, $id]);
            } else {
                $stmt = db()->prepare('INSERT INTO skills (name, sort_order) VALUES (?, ?)');
                $stmt->execute([$name, $sortOrder]);
            }
        }
        redirectTo('admin.php');
    }

    if ($action === 'delete_skill') {
        $stmt = db()->prepare('DELETE FROM skills WHERE id = ?');
        $stmt->execute([(int) ($_POST['id'] ?? 0)]);
        redirectTo('admin.php');
    }

    if ($action === 'save_company') {
        $id = (int) ($_POST['id'] ?? 0);
        $name = postString('name');
        $location = postString('location');
        $sortOrder = (int) ($_POST['sort_order'] ?? 0);

        if ($name !== '' && $location !== '') {
            if ($id > 0) {
                $stmt = db()->prepare('UPDATE companies SET name = ?, location = ?, sort_order = ? WHERE id = ?');
                $stmt->execute([$name, $location, $sortOrder, $id]);
            } else {
                $stmt = db()->prepare('INSERT INTO companies (name, location, sort_order) VALUES (?, ?, ?)');
                $stmt->execute([$name, $location, $sortOrder]);
            }
        }
        redirectTo('admin.php');
    }

    if ($action === 'delete_company') {
        $stmt = db()->prepare('DELETE FROM companies WHERE id = ?');
        $stmt->execute([(int) ($_POST['id'] ?? 0)]);
        redirectTo('admin.php');
    }

    if ($action === 'save_experience') {
        $id = (int) ($_POST['id'] ?? 0);
        $role = postString('role');
        $companyId = (int) ($_POST['company_id'] ?? 0);
        $startLabel = postString('start_label');
        $endLabel = postString('end_label');
        $sortOrder = (int) ($_POST['sort_order'] ?? 0);

        if ($role !== '' && $companyId > 0 && $startLabel !== '' && $endLabel !== '') {
            if ($id > 0) {
                $stmt = db()->prepare('UPDATE experiences SET role = ?, company_id = ?, start_label = ?, end_label = ?, sort_order = ? WHERE id = ?');
                $stmt->execute([$role, $companyId, $startLabel, $endLabel, $sortOrder, $id]);
            } else {
                $stmt = db()->prepare('INSERT INTO experiences (role, company_id, start_label, end_label, sort_order) VALUES (?, ?, ?, ?, ?)');
                $stmt->execute([$role, $companyId, $startLabel, $endLabel, $sortOrder]);
            }
        }
        redirectTo('admin.php');
    }

    if ($action === 'delete_experience') {
        $stmt = db()->prepare('DELETE FROM experiences WHERE id = ?');
        $stmt->execute([(int) ($_POST['id'] ?? 0)]);
        redirectTo('admin.php');
    }
}

$skills = fetchAllRows('SELECT * FROM skills ORDER BY sort_order, id');
$companies = fetchAllRows('SELECT * FROM companies ORDER BY sort_order, id');
$experiences = fetchAllRows(
    'SELECT e.*, c.name AS company_name
     FROM experiences e
     INNER JOIN companies c ON c.id = e.company_id
     ORDER BY e.sort_order, e.id'
);
?>
<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin CV</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body class="admin-body">
  <main class="admin-shell">
    <header class="admin-header">
      <div>
        <h1>Pannello admin CV</h1>
        <p>Qui puoi gestire skill, aziende ed esperienze. In alternativa puoi aprire direttamente il file <code>data/cv.sqlite</code> con un DB manager esterno.</p>
      </div>
      <a class="admin-link" href="index.php">Apri il CV</a>
    </header>

    <section class="admin-grid">
      <section class="panel">
        <h2>Skill</h2>
        <form method="post" class="stack-form">
          <input type="hidden" name="action" value="save_skill">
          <input type="hidden" name="id" value="0">
          <label>Nome skill<input type="text" name="name" required></label>
          <label>Ordine<input type="number" name="sort_order" value="99"></label>
          <button type="submit">Aggiungi skill</button>
        </form>

        <div class="list-block">
          <?php foreach ($skills as $skill): ?>
            <form method="post" class="inline-editor">
              <input type="hidden" name="action" value="save_skill">
              <input type="hidden" name="id" value="<?= (int) $skill['id'] ?>">
              <input type="text" name="name" value="<?= htmlspecialchars($skill['name']) ?>" required>
              <input type="number" name="sort_order" value="<?= (int) $skill['sort_order'] ?>">
              <button type="submit">Salva</button>
            </form>
            <form method="post" class="inline-delete">
              <input type="hidden" name="action" value="delete_skill">
              <input type="hidden" name="id" value="<?= (int) $skill['id'] ?>">
              <button type="submit" class="danger">Elimina</button>
            </form>
          <?php endforeach; ?>
        </div>
      </section>

      <section class="panel">
        <h2>Aziende</h2>
        <form method="post" class="stack-form">
          <input type="hidden" name="action" value="save_company">
          <input type="hidden" name="id" value="0">
          <label>Nome azienda<input type="text" name="name" required></label>
          <label>Localita'<input type="text" name="location" required></label>
          <label>Ordine<input type="number" name="sort_order" value="99"></label>
          <button type="submit">Aggiungi azienda</button>
        </form>

        <div class="list-block">
          <?php foreach ($companies as $company): ?>
            <form method="post" class="inline-editor company-editor">
              <input type="hidden" name="action" value="save_company">
              <input type="hidden" name="id" value="<?= (int) $company['id'] ?>">
              <input type="text" name="name" value="<?= htmlspecialchars($company['name']) ?>" required>
              <input type="text" name="location" value="<?= htmlspecialchars($company['location']) ?>" required>
              <input type="number" name="sort_order" value="<?= (int) $company['sort_order'] ?>">
              <button type="submit">Salva</button>
            </form>
            <form method="post" class="inline-delete">
              <input type="hidden" name="action" value="delete_company">
              <input type="hidden" name="id" value="<?= (int) $company['id'] ?>">
              <button type="submit" class="danger">Elimina</button>
            </form>
          <?php endforeach; ?>
        </div>
      </section>

      <section class="panel panel-wide">
        <h2>Esperienze</h2>
        <form method="post" class="stack-form grid-form">
          <input type="hidden" name="action" value="save_experience">
          <input type="hidden" name="id" value="0">
          <label>Ruolo<input type="text" name="role" required></label>
          <label>Azienda
            <select name="company_id" required>
              <option value="">Seleziona</option>
              <?php foreach ($companies as $company): ?>
                <option value="<?= (int) $company['id'] ?>"><?= htmlspecialchars($company['name']) ?></option>
              <?php endforeach; ?>
            </select>
          </label>
          <label>Dal<input type="text" name="start_label" placeholder="2024" required></label>
          <label>Al<input type="text" name="end_label" placeholder="in corso" required></label>
          <label>Ordine<input type="number" name="sort_order" value="99"></label>
          <button type="submit">Aggiungi esperienza</button>
        </form>

        <div class="list-block">
          <?php foreach ($experiences as $experience): ?>
            <form method="post" class="inline-editor experience-editor">
              <input type="hidden" name="action" value="save_experience">
              <input type="hidden" name="id" value="<?= (int) $experience['id'] ?>">
              <input type="text" name="role" value="<?= htmlspecialchars($experience['role']) ?>" required>
              <select name="company_id" required>
                <?php foreach ($companies as $company): ?>
                  <option value="<?= (int) $company['id'] ?>"<?= (int) $company['id'] === (int) $experience['company_id'] ? ' selected' : '' ?>>
                    <?= htmlspecialchars($company['name']) ?>
                  </option>
                <?php endforeach; ?>
              </select>
              <input type="text" name="start_label" value="<?= htmlspecialchars($experience['start_label']) ?>" required>
              <input type="text" name="end_label" value="<?= htmlspecialchars($experience['end_label']) ?>" required>
              <input type="number" name="sort_order" value="<?= (int) $experience['sort_order'] ?>">
              <button type="submit">Salva</button>
            </form>
            <div class="experience-company"><?= htmlspecialchars($experience['company_name']) ?></div>
            <form method="post" class="inline-delete">
              <input type="hidden" name="action" value="delete_experience">
              <input type="hidden" name="id" value="<?= (int) $experience['id'] ?>">
              <button type="submit" class="danger">Elimina</button>
            </form>
          <?php endforeach; ?>
        </div>
      </section>
    </section>
  </main>
</body>
</html>
