<?php

$data = json_decode($payload, true);

$year = $data['year'];
$month = $data['month'];
$day = $data['day'];

$month_obj = DateTime::createFromFormat('!m', $month);
$month_display = $month_obj ? $month_obj->format('F') : $month;

if (!is_null($data['state'])) {
    $title = $month_display . ' ' . $day . ', ' . $year . ' - ' . $data['venue'] . ', ' . $data['city'] . ', ' . $data['state'] . ', ' . $data['country'];
} else {
    $title = $month_display . ' ' . $day . ', ' . $year . ' - ' . $data['venue'] . ', ' . $data['city'] . ', ' . $data['country'];
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Live Nirvana | Concert Chronology | <?php echo $data['year']; ?> | <?php echo $title; ?></title>

        <?php require_once('../includes/head_scripts.php'); ?>

    </head>
    <body>

        <?php require_once('../includes/nav.php'); ?>

        <main>
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <ol class="breadcrumb">
                            <li><a href="/">LiveNIRVANA.com</a></li>
                            <li><a href="/concerts/">Concert Chronology</a></li>
<?php if ($year == '1985' || $year == '1986'): ?>
                            <li><a href="/concerts/85_86.php">1985 &gt; 1986</a></li>
<?php else: ?>
                            <li><a href="/concerts/<?php echo substr($year, -2); ?>.php"><?php echo $data['year']; ?></a></li>
<?php endif; ?>
                            <li class="active"><?php echo($title); ?></li>
                        </ol>
                        <h1 class="page-header">LIVE NIRVANA Concert Chronology <small><?php echo $title; ?></small></h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="list-group">
                            <a href="/concerts/85_86.php" class="list-group-item<?php if ($year == '1985' || $year == '1986'): ?> active<?php endif; ?>">1985 &gt; 1986</a>
                            <a href="/concerts/87.php" class="list-group-item<?php if ($year == '1987'): ?> active<?php endif; ?>">1987</a>
                            <a href="/concerts/88.php" class="list-group-item<?php if ($year == '1988'): ?> active<?php endif; ?>">1988</a>
                            <a href="/concerts/89.php" class="list-group-item<?php if ($year == '1989'): ?> active<?php endif; ?>">1989</a>
                            <a href="/concerts/90.php" class="list-group-item<?php if ($year == '1990'): ?> active<?php endif; ?>">1990</a>
                            <a href="/concerts/91.php" class="list-group-item<?php if ($year == '1991'): ?> active<?php endif; ?>">1991</a>
                            <a href="/concerts/92.php" class="list-group-item<?php if ($year == '1992'): ?> active<?php endif; ?>">1992</a>
                            <a href="/concerts/93.php" class="list-group-item<?php if ($year == '1993'): ?> active<?php endif; ?>">1993</a>
                            <a href="/concerts/94.php" class="list-group-item<?php if ($year == '1994'): ?> active<?php endif; ?>">1994</a>
                            <a href="/concerts/glance.php" class="list-group-item">All Available Recordings At A Glance</a>
                            <a href="/concerts/cancelled.php" class="list-group-item">Cancelled Shows</a>
                            <a href="/concerts/unknown.php" class="list-group-item">Unknown Images And Memorabilia</a>
                            <a href="/concerts/updates.php" class="list-group-item">Updates</a>
                            <a href="mailto:contact@livenirvana.com" class="list-group-item">Contact</a>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-md-6">
                                <h2 class="page-header">Artist</h2>
                                <ul class="list-unstyled">
<?php foreach ($data['band'] as $bandmember): ?>
<?php if ($bandmember['type'] == 'group'): ?>
                                    <li><?php echo $bandmember['name']; ?>
                                        <ul>
<?php foreach ($bandmember['members'] as $nested_member): ?>
                                            <li><?php echo $nested_member['name']; ?> <i>(<?php echo $nested_member['duty']; ?>)</i></li>
<?php endforeach; ?>
                                        </ul>
                                    </li>
<?php else: ?>
                                    <li><?php echo $bandmember['name']; ?><?php if (!empty($bandmember['duty'])): ?> <i>(<?php echo $bandmember['duty']; ?>)</i><?php endif; ?></li>
<?php endif; ?>
<?php endforeach; ?>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h2 class="page-header">Crew</h2>
<?php if (!empty($data['crew'])): ?>
                                <ul class="list-unstyled">
<?php foreach ($data['crew'] as $crewmember): ?>
                                    <li><?php echo $crewmember['name']; ?><?php if (!empty($crewmember['duty'])): ?> <i>(<?php echo $crewmember['duty']; ?>)</i><?php endif; ?></li>
<?php endforeach; ?>
                                </ul>
<?php else: ?>
                                <ul class="list-unstyled">
                                    <li>No Info</li>
                                </ul>
<?php endif; ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <h2 class="page-header">Buyer</h2>
<?php if (isset($data['buyer']['company'])): ?>
                                <ul class="list-unstyled">
                                    <li><?php echo $data['buyer']['company']; ?>
<?php if (!empty($data['buyer']['names'])): ?>
                                        <ul>
<?php foreach ($data['buyer']['names'] as $buyername): ?>
                                            <li><?php echo $buyername; ?></li>
<?php endforeach; ?>
                                        </ul>
<?php endif;?>
                                    </li>
                                </ul>
<?php else: ?>
<?php if (!empty($data['buyer']['names'])): ?>
                                <ul class="list-unstyled">
<?php foreach ($data['buyer']['names'] as $buyername): ?>
                                    <li><?php echo $buyername; ?></li>
<?php endforeach; ?>
                                </ul>
<?php else: ?>
                                <ul class="list-unstyled">
                                    <li>No Info</li>
                                </ul>
<?php endif; ?>
<?php endif; ?>
                            </div>
                            <div class="col-md-6">
                                <h2 class="page-header">Schedule</h2>
<?php if (!empty($data['schedule'])): ?>
                                <dl class="dl-horizontal">
<?php foreach ($data['schedule'] as $scheduleitem): ?>
                                    <dt><?php echo $scheduleitem['event']; ?></dt><dd><?php echo !is_null($scheduleitem['time']) ? $scheduleitem['time'] : '&#8230;:&#8230;'; ?></dd>
<?php endforeach; ?>
                                </dl>
<?php else: ?>
                                <p>No Info</p>
<?php endif; ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <h2 class="page-header">Soundcheck<?php if ($data['soundcheck_incomplete']): ?> <small>incomplete</small><?php endif; ?></h2>
<?php if (!empty($data['soundcheck'])): ?>
                                <ol class="list-unstyled">
<?php foreach ($data['soundcheck'] as $songitem): ?>
<?php if ($songitem['type'] ==  'song'): ?>
                                    <li><span class="green"><?php echo $songitem['text']; ?></span><?php foreach ($songitem['notes'] as $songnotes): ?> <span class="label label-default"><?php echo $songnotes; ?></span><?php endforeach; ?></li>
<?php elseif ($songitem['type'] ==  'banter'): ?>
                                    <li><aside class="collapse banter"><?php echo $songitem['person']; ?> - <q><?php echo $songitem['text']; ?></q></aside></li>
<?php elseif ($songitem['type'] ==  'jam'): ?>
                                    <li><aside class="collapse jam"><b><i><?php echo $songitem['text']; ?></i></b><?php foreach ($songitem['notes'] as $songnotes): ?> <span class="label label-default"><?php echo $songnotes; ?></span><?php endforeach; ?></aside></li>
<?php elseif ($songitem['type'] ==  'notes'): ?>
                                    <li><?php foreach ($songitem['notes'] as $songnotes): ?> <span class="label label-default"><?php echo $songnotes; ?></span><?php endforeach; ?></li>
<?php endif; ?>
<?php endforeach; ?>
                                </ol>
<?php else: ?>
                                <ol class="list-unstyled">
                                    <li>No Info</li>
                                </ol>
<?php endif; ?>
                                <h2 class="page-header">Set<?php if ($data['set_incomplete']): ?> <small>incomplete</small><?php endif; ?></h2>
<?php if (!empty($data['set'])): ?>
                                <ol class="list-unstyled">
<?php foreach ($data['set'] as $songitem): ?>
<?php if ($songitem['type'] ==  'song'): ?>
                                    <li><span class="green"><?php echo $songitem['text']; ?></span><?php foreach ($songitem['notes'] as $songnotes): ?> <span class="label label-default"><?php echo $songnotes; ?></span><?php endforeach; ?></li>
<?php elseif ($songitem['type'] ==  'banter'): ?>
                                    <li><aside class="collapse banter"><?php echo $songitem['person']; ?> - <q><?php echo $songitem['text']; ?></q></aside></li>
<?php elseif ($songitem['type'] ==  'jam'): ?>
                                    <li><aside class="collapse jam"><b><i><?php echo $songitem['text']; ?></i></b><?php foreach ($songitem['notes'] as $songnotes): ?> <span class="label label-default"><?php echo $songnotes; ?></span><?php endforeach; ?></aside></li>
<?php elseif ($songitem['type'] ==  'notes'): ?>
                                    <li><?php foreach ($songitem['notes'] as $songnotes): ?> <span class="label label-default"><?php echo $songnotes; ?></span><?php endforeach; ?></li>
<?php endif; ?>
<?php endforeach; ?>
                                </ol>
<?php else: ?>
                                <p>No Info</p>
<?php endif; ?>
                                <button type="button" class="btn btn-default btn-bantz btn-sm" data-toggle="collapse" data-target=".banter"><i class="fas fa-eye"></i> Stage Banter</button>
                                <button type="button" class="btn btn-default btn-jams btn-sm" data-toggle="collapse" data-target=".jam"><i class="fa fa-eye"></i> Short Jams</button>
                            </div>
                            <div class="col-sm-6">
                                <h2 class="page-header">Set Range</h2>
                                <div id="donutchart" class="row" style="width:100%; height:220px; margin-bottom:15px; padding:0;"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
<?php if (!empty($data['transmission'])): ?>
                                <h2 class="page-header">Transmission</h2>
                                <ul class="list-unstyled">
                                    <li><?php echo $data['transmission']['info']; ?>, <cite><?php echo $data['transmission']['show']; ?></cite></li>
                                </ul>
<?php endif; ?>
<?php if (!empty($data['rehearsel_circulating_sources'])): ?>
                                <h2 class="page-header">Soundcheck/Dress Rehearsal Circulating Recordings</h2>
<?php foreach ($data['rehearsel_circulating_sources'] as $source): ?>
                                <h5 class="source-title"><span class="green"><?php echo $source['name']; ?><?php if (!$source['complete']): ?> <small>incomplete</small><?php endif; ?></span></h5>
                                <dl class="dl-horizontal">
                                    <dt>Equipment:</dt>
                                    <dd><?php echo $source['equipment']; ?></dd>
<?php if (!is_null($source['generation'])): ?>
                                    <dt>Lowest Generation:</dt>
                                    <dd><?php echo $source['generation']; ?></dd>
<?php endif ?>
<?php if (!is_null($source['audio-generation'])): ?>
                                    <dt>Lowest Audio Generation:</dt>
                                    <dd><?php echo $source['audio-generation']; ?></dd>
<?php endif ?>
<?php if (!is_null($source['video-generation'])): ?>
                                    <dt>Lowest Video Generation:</dt>
                                    <dd><?php echo $source['video-generation']; ?></dd>
<?php endif ?>
                                    <dt>Length / Sound Quality:</dt>
                                    <dd><?php echo $source['length-sound']; ?></dd>
<?php if (!empty($source['notes'])): ?>
                                    <dt>Notes:</dt>
<?php foreach ($source['notes'] as $note): ?>
                                    <dd><?php echo $note; ?></dd>
<?php endforeach; ?>
<?php endif;?>
                                </dl>
<?php endforeach; ?>
<?php endif; ?>
<?php if (empty($data['rehearsel_circulating_sources'])): ?>
                                <h2 class="page-header">Circulating Recordings</h2>
<?php else: ?>
                                <h2 class="page-header">Night Show Circulating Recordings</h2>
<?php endif; ?>
<?php if (!empty($data['circulating_sources'])): ?>
<?php foreach ($data['circulating_sources'] as $source): ?>
                                <h5 class="source-title"><span class="green"><?php echo $source['name']; ?><?php if (!$source['complete']): ?> <small>incomplete</small><?php endif; ?></span></h5>
                                <dl class="dl-horizontal">
                                    <dt>Equipment:</dt>
                                    <dd><?php echo $source['equipment']; ?></dd>
<?php if (!is_null($source['generation'])): ?>
                                    <dt>Lowest Generation:</dt>
                                    <dd><?php echo $source['generation']; ?></dd>
<?php endif ?>
<?php if (!is_null($source['audio-generation'])): ?>
                                    <dt>Lowest Audio Generation:</dt>
                                    <dd><?php echo $source['audio-generation']; ?></dd>
<?php endif ?>
<?php if (!is_null($source['video-generation'])): ?>
                                    <dt>Lowest Video Generation:</dt>
                                    <dd><?php echo $source['video-generation']; ?></dd>
<?php endif ?>
                                    <dt>Length / Sound Quality:</dt>
                                    <dd><?php echo $source['length-sound']; ?></dd>
<?php if (!empty($source['notes'])): ?>
                                    <dt>Notes:</dt>
<?php foreach ($source['notes'] as $note): ?>
                                    <dd><?php echo $note; ?></dd>
<?php endforeach; ?>
<?php endif;?>
                                </dl>
<?php endforeach; ?>
<?php else: ?>
                                <p>No Info</p>
<?php endif; ?>
                                <h2 class="page-header">Uncirculated Recordings</h2>
<?php if (!empty($data['uncirculated_sources'])): ?>
<?php foreach ($data['uncirculated_sources'] as $uncirculated): ?>
                                <h5 class="source-title"><span class="red"><?php echo $uncirculated['name']; ?></span></h5>
                                <p><?php echo $uncirculated['note']; ?></p>
<?php endforeach; ?>
<?php else:?>
                                <p>No Info</p>
<?php endif; ?>
                                <h2 class="page-header">Notes</h2>
<?php if (!empty($data['notes'])): ?>
                                <ul class="list-unstyled">
<?php foreach ($data['notes'] as $note): ?>
                                    <li><?php echo $note; ?></li>
<?php endforeach; ?>
                                </ul>
<?php else: ?>
                                <p>No Info</p>
<?php endif; ?>
                                <h2 class="page-header">Press Reviews</h2>
<?php if (!empty($data['press'])): ?>
                                <ul class="list-unstyled">
<?php foreach ($data['press'] as $press): ?>
                                    <li><a href="<?php echo $press['url']; ?>"><?php echo $press['text']; ?></a></li>
<?php endforeach; ?>
                                </ul>
<?php else: ?>
                                <ul class="list-unstyled">
                                    <li>No Info</li>
                                </ul>
<?php endif; ?>
<?php if (!empty($data['memorabilia'])): ?>
                                <h2 class="page-header">Memorabilia</h2>
                                <div class="fotorama" data-nav="thumbs" data-allowfullscreen="true" data-width="700" data-ratio="700/467" data-max-width="100%">
<?php foreach ($data['memorabilia'] as $memorabilia): ?>
                                    <img src="<?php echo $memorabilia['url']; ?>" data-caption="<?php echo $memorabilia['caption']; ?>" alt="<?php echo $memorabilia['caption']; ?>">
<?php endforeach; ?>
                                </div>
<?php endif; ?>
<?php if (!empty($data['images'])): ?>
                                <h2 class="page-header">Images</h2>
                                <div class="fotorama" data-nav="thumbs" data-allowfullscreen="true" data-width="700" data-ratio="700/467" data-max-width="100%">
<?php foreach ($data['images'] as $image): ?>
                                    <img src="<?php echo $image['url']; ?>" data-caption="<?php echo $image['caption']; ?>" alt="<?php echo $image['caption']; ?>">
<?php endforeach; ?>
                                </div>
<?php endif; ?>
                                <hr>
                                <nav aria-label="...">
                                    <ul class="pager">
<?php if (isset($data['navigation']['previous'])): ?>
                                        <li><a href="<?php echo $data['navigation']['previous']; ?>.php"><i class="fas fa-arrow-left"></i> Prev. Show</a></li>
<?php endif; ?>
<?php if (isset($data['navigation']['next'])): ?>
                                        <li><a href="<?php echo $data['navigation']['next']; ?>.php">Next Show <i class="fas fa-arrow-right"></i></a></li>
<?php endif; ?>
                                    </ul>
                                </nav>
                                <a id="back-to-top" href="#top" class="btn btn-default btn-lg btn-round back-to-top" role="button" title="Click to return on the top page" data-toggle="tooltip" data-placement="left"><i class="fas fa-arrow-up"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <?php require_once('../includes/footer.php'); ?>
        <?php require_once('../includes/footer_scripts.php'); ?>

        <script>
            google.charts.load("current", {packages:["corechart"]});
            google.charts.setOnLoadCallback(drawChart);
            function drawChart() {
              var data = google.visualization.arrayToDataTable([
                ['Album', 'Number of songs'],
                ['Bleach material',     <?php echo $data['graph']['bleach']; ?>],
                ['Nevermind material',  <?php echo $data['graph']['nevermind']; ?>],
                ['In Utero material',  <?php echo $data['graph']['inutero']; ?>],
                ['Non-album material',    <?php echo $data['graph']['non']; ?>]
              ]);

              var options = {
              width: '100%',
              height: '220',
              chartArea:{left:5,top:5,width:'100%',height:'180'},
              sliceVisibilityThreshold:'0',
              legend: { position: 'right', alignment: 'start', maxLines: '4', textStyle: {fontSize: 12} },
                pieHole: 0.5,
                colors: ['#34495e', '#003399', '#95a5a6', 'green'],
                animation: {
                        duration: 1000,
                       // easing: 'in',
                        startup: true
                    }
              };

              var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
              chart.draw(data, options);
            }
        </script>
    </body>
</html>