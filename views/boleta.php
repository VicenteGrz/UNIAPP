<h1>Boleta de Calificaciones</h1>
<ul>
<?php foreach ($grades as $grade) : ?>
    <li><?php echo htmlspecialchars($grade['materia']) . ': ' . htmlspecialchars($grade['calificacion']); ?></li>
<?php endforeach; ?>
</ul>