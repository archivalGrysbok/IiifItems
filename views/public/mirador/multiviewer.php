<?php
    $mirador_path = get_option('iiifitems_mirador_path');
    $urlJs = $mirador_path . '/mirador.js';
    $urlCss = $mirador_path . '/css/mirador-combined.css';
    $urls = array();
    if (!empty($item_ids)) {
        foreach ($item_ids as $item_id) {
            $urls[] = js_escape(public_full_url(array('things' => 'items', 'id' => $item_id), 'iiifitems_manifest'));
        }
    }
    if (!empty($manifests)) {
        foreach ($manifests as $manifest) {
            if (trim($manifest)) {
                $urls[] = js_escape($manifest);
            }
        }
    }
?>
<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <link rel="stylesheet" type="text/css" href="<?php echo html_escape($urlCss); ?>">
    <style type="text/css">
        body { padding: 0; margin: 0; overflow: hidden; font-size: 70%; }
        #viewer { background: #333; width: 100%; height: 100%; position: fixed; }
    </style>
</head>
<body>
    <div id="viewer"></div>
    <script src="<?php echo $urlJs; ?>"></script>
    <script type="text/javascript">
    $(function() {
        var anno_token;
        Mirador({
            "id": "viewer",
            "buildPath": "<?php echo html_escape($mirador_path) . '/'; ?>",
            "layout": "1",
            "data": [
                <?php foreach ($urls as $i => $url): ?>
                <?php if ($i > 0) echo ','; ?>{ "manifestUri": <?php echo $url; ?> }
                <?php endforeach; ?>
            ],
            "windowObjects": [{
                imageMode: "ImageView",
                <?php if (!empty($urls)): ?>
                loadedManifest: <?php echo $urls[0]; ?>,
                <?php endif; ?>
                sidePanel: true,
                slotAddress: "row1.column1",
                viewType: "ImageView",
                annotationLayer: true
            }],
            "windowSettings": {
                canvasControls: {
                    annotations: {
                        annotationLayer: true,
                        annotationState: "on",
                        annotationRefresh: true
                    }
                },
                sidePanelVisible: false
            },
            "autoHideControls": false,
            "mainMenuSettings": {
                show: false
            }
        });
    });
    </script>
</body>
</html>
