<?php
$start = date('Y-m-d', strtotime("-2 weeks"));
$end = date('Y-m-d', strtotime("+1 day"));
if (isset($_POST['start']) && isset($_POST['end'])) {
    $start = filterStringPost('start');
    $end = filterStringPost('end');
}

$query = "SELECT count(id) as count, body
FROM `responses`
WHERE `created` >= '{$start}'
AND `created` <= '{$end}'
AND `type` = 'NS'
GROUP BY body
ORDER BY count DESC";
$data = get_db($query);

$errors = [
    'allegatocorrotto' => [
        'count' => 0,
        'body' => ''
    ],
    'codicefiscale' => [
        'count' => 0,
        'body' => ''
    ],
    'fatturaduplicata' => [
        'count' => 0,
        'body' => ''
    ],
    'dimensionifile' => [
        'count' => 0,
        'body' => ''
    ],
    'nomeattachment' => [
        'count' => 0,
        'body' => ''
    ],
    'calcoloimposta' => [
        'count' => 0,
        'body' => ''
    ],
    'partitaiva' => [
        'count' => 0,
        'body' => ''
    ]
];

foreach ($data as $dato) {
    $dato['body'] = str_replace('File non conforme al formato (nella descrizione del messaggio Ã¨ riportata lâ€™indicazione puntuale della non conformitÃ ) : ', '', $dato['body']);

    if (strpos($dato['body'], 'JVBER') !== false) {
        $errors['allegatocorrotto'] = [
            'count' => $errors['allegatocorrotto']['count'] + $dato['count'],
            'body' => 'Allegato corrotto'
        ];
    } elseif (strpos($dato['body'], '/9j/4') !== false) {
        $errors['allegatocorrotto'] = [
            'count' => $errors['allegatocorrotto']['count'] + $dato['count'],
            'body' => 'Allegato corrotto'
        ];
    } elseif (strpos($dato['body'], 'base64Binary') !== false) {
        $errors['allegatocorrotto'] = [
            'count' => $errors['allegatocorrotto']['count'] + $dato['count'],
            'body' => 'Allegato corrotto'
        ];
    } elseif (strpos($dato['body'], 'CodiceFiscale') !== false) {
        $errors['codicefiscale'] = [
            'count' => $errors['codicefiscale']['count'] + $dato['count'],
            'body' => 'CodiceFiscale non valido'
        ];
    } elseif (strpos($dato['body'], 'IdCodice non valido') !== false) {
        $errors['partitaiva'] = [
            'count' => $errors['partitaiva']['count'] + $dato['count'],
            'body' => 'Codice Partita Iva non valido'
        ];
    } elseif (strpos($dato['body'], 'Fattura duplicata numero') !== false) {
        $errors['fatturaduplicata'] = [
            'count' => $errors['fatturaduplicata']['count'] + $dato['count'],
            'body' => 'Fattura duplicata nel lotto'
        ];
    } elseif (strpos($dato['body'], 'Le dimensioni del file superano quelle ammesse') !== false) {
        $errors['dimensionifile'] = [
            'count' => $errors['dimensionifile']['count'] + $dato['count'],
            'body' => 'Le dimensioni del file superano quelle ammesse'
        ];
    } elseif (strpos($dato['body'], 'One of \'{NomeAttachment}\' is expected') !== false) {
        $errors['nomeattachment'] = [
            'count' => $errors['nomeattachment']['count'] + $dato['count'],
            'body' => 'Allegato presente senza il campo NomeAttachment'
        ];
    } elseif (strpos($dato['body'], '2.2.2.6 Imposta non calcolato') !== false) {
        $errors['calcoloimposta'] = [
            'count' => $errors['calcoloimposta']['count'] + $dato['count'],
            'body' => 'Imposta non calcolata secondo le specifiche tecniche'
        ];
    } else {
        $errors[] = [
            'count' => $dato['count'],
            'body' => $dato['body']
        ];
    }
}

$sorted = [];
foreach ($errors as $key => $row)
{
    $sorted[$key] = $row['count'];
}
array_multisort($sorted, SORT_DESC, $errors);
?>

<div class="row">
    <div class="col s12 m8 offset-m2">
        <form class="" action="" method="post">
            <h5>Statistiche sulle motivazioni di scarto:</h5>
            <div class="row">
                <div class="col s6 m3">
                    Data inizio:
                    <input type="date" class="datepicker" name="start" value="<?= $start ?>">
                </div>
                <div class="col s6 m3">
                    Data fine:
                    <input type="date" class="datepicker" name="end" value="<?= $end ?>">
                </div>
                <br>
                <input class="btn teal darken-3" type="submit" value="Mostra">
            </div>
        </form>

        <table>
            <thead>
                <tr>
                    <th class="center">Occorrenze</th>
                    <th>Motivo</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($errors as $dato) { ?>
                    <?php if ($dato['count'] > 0) { ?>
                        <tr>
                            <td class="center"><?= $dato['count'] ?></td>
                            <td><?= $dato['body'] ?></td>
                        </tr>
                    <?php } ?>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
