<?php
$signCircleBase64 = "data:image/png;base64,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";

$bkiRed100 = "data:image/png;base64,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";

$signBase64 = "data:image/png;base64,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";

$sign150Base64 = "data:image/png;base64,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";
?>