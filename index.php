<?php

$profile = json_decode(file_get_contents('seriousgames.jsonld'), true);

$title = $profile['prefLabel']['en'];
$url = $profile['@id'];

$GLOBALS['url'] = $url;

function sort_by_label($a, $b)
{
    return strcmp($a['prefLabel']['en'], $b['prefLabel']['en']);
}

function echo_table($terms, $title, $type, $class)
{
    global $url;
    ?>
    <h2 class="page-header"><?php echo $title; ?></h2>
    <div class="panel panel-default table-responsive">
        <!-- Table Header -->
        <table class="table table-hover">
            <thead>
            <tr class="<?php echo $class; ?>">
                <th>Label</th>
                <th>Description</th>
                <th>Scope Note</th>
                <th>ID (IRI)</th>
                <th>Relationships</th>
                <th>Closely Related Term</th>
                <th>Vocabulary</th>
            </tr>
            </thead>
            <?php

            foreach ($terms as $term):
                $id = isset($term['@id']) ? $term['@id'] : '';
                $prefLabel = isset($term['prefLabel']) ? $term['prefLabel']['en'] : '';
                $description = isset($term['definition']) ? $term['definition']['en'] : '';
                $scope_note = isset($term['scopeNote']) ? $term['scopeNote']['en'] : '';
                $close_match = isset($term['closeMatch']) ? $term['closeMatch']['@id'] : '';
                $related_term = isset($term['closelyRelatedNaturalLanguageTerm']) ? $term['closelyRelatedNaturalLanguageTerm']['@id'] : '';
                $tr_class = isset($term['reference']) && $term['reference'] ? 'warning' : '';
                $in_scheme = isset($term['inScheme']) ? $term['inScheme'] : $url;


                ?>
                <tbody typeof="xapi:<?php echo $type; ?>" about="<?php echo $id; ?>" id="<?php echo $prefLabel; ?>">
                <tr class="<?php echo $tr_class; ?>">
                    <td property="skos:prefLabel" lang="en" xml:lang="en" content="<?php echo $prefLabel; ?>"><?php echo $prefLabel; ?></td>
                    <td property="skos:definition" lang="en" xml:lang="en" content="<?php echo $description; ?>">
                        <?php echo $description; ?>
                    </td>
                    <td property="skos:scopeNote" lang="en" xml:lang="en" content="<?php echo $scope_note; ?>">
                        <?php echo $scope_note; ?>
                    </td>
                    <td><a href="<?php echo $id; ?>"><?php echo $id; ?></a>
                    </td>
                    <td rel="skos:closeMatch" resource="<?php echo $close_match; ?>">
                        <?php if ($close_match): ?>
                            <strong>closeMatch:</strong>
                            <a href="<?php echo $close_match; ?>" target="_blank"><?php echo $close_match; ?></a>
                        <?php endif; ?>
                    </td>
                    <td rel="xapi:closelyRelatedNaturalLanguageTerm" resource="<?php echo $related_term; ?>">
                        <a href="<?php echo $related_term; ?>" target="_blank"><?php echo $related_term; ?></a>
                    </td>
                    <td rel="skos:inScheme" resource="<?php echo $in_scheme; ?>">
                        <a href="<?php echo $in_scheme; ?>"><?php echo $in_scheme; ?></a></td>
                </tr>
                </tbody>
                <?php
            endforeach;
            ?>
        </table>
    </div>
    <?php
}

function echo_drop_down($terms, $title)
{
    ?>
    <li class="dropdown">
        <a href="#" class="dropdown-toggle active" data-toggle="dropdown"><?php echo $title; ?><b class="caret"></b></a>
        <ul class="dropdown-menu">
            <?php foreach ($terms as $term):
                $name = $term['prefLabel']['en'];
                ?>
                <li><a href="#<?php echo $name; ?>"><?php echo $name; ?></a></li>
            <?php endforeach; ?>
        </ul>
    </li>
    <?php
}


$verbs = $profile['verbs'];
$activities = $profile['activity-types'];
$extensions = $profile['extensions'];

$references = $profile['references'];

foreach ($references as $reference) {
    if (isset($reference['@type'])) {
        $prefLabel = substr(strrchr($reference['@id'], '/'), 1);
        $reference['prefLabel'] = array(
            'en' => $prefLabel
        );
        $reference['reference'] = true;

        switch ($reference['@type']) {
            case 'Verb':
                $verbs[] = $reference;
                break;
            case 'Extension':
                $extensions[] = $reference;
                break;
            default:
                $activities[] = $reference;
                break;
        }
    }
}

$created = $profile['created']['en'];
$modified = $profile['modified']['en'];

usort($verbs, 'sort_by_label');
usort($activities, 'sort_by_label');
usort($extensions, 'sort_by_label');

?>
<!DOCTYPE html>
<html lang="en" xml:lang="en">
<head>
    <meta content="text/html; charset=UTF-8" http-equiv="Content-Type"/>
    <title>Experience API (xAPI) - <?php echo $title; ?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css"/>
</head>
<body>
<div class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span>
                <span class="icon-bar"></span> <span class="icon-bar"></span></button>
            <a class="navbar-brand" href="<?php echo $url; ?>"><?php echo $title; ?></a></div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <?php
                echo_drop_down($verbs, 'Verbs');
                echo_drop_down($activities, 'Activity Types');
                echo_drop_down($extensions, 'Extensions');
                ?>
            </ul>
        </div>
        <!--/.nav-collapse -->
    </div>
</div
<br/>
<br/>
<div xmlns="http://www.w3.org/1999/xhtml" class="container-fluid" prefix="
    dcterms: http://purl.org/dc/terms/
    foaf: http://xmlns.com/foaf/0.1/
    owl: http://www.w3.org/2002/07/owl#
    prov: http://www.w3.org/ns/prov#
    rdf: http://www.w3.org/1999/02/22-rdf-syntax-ns#
    rdfs: http://www.w3.org/2000/01/rdf-schema#
    skos: http://www.w3.org/2004/02/skos/core#
    xapi: https://w3id.org/xapi/ontology#
    xsd: http://www.w3.org/2001/XMLSchema#">
    <div typeof="skos:ConceptScheme" about="<?php echo $url; ?>">
        <div property="skos:prefLabel" lang="en" xml:lang="en" content="<?php echo $title; ?>">
            <h2 class="page-header"><?php echo $title; ?></h2>
        </div>
        <div property="skos:editorialNote" lang="en" xml:lang="en" content="This vocabulary was designed for the Serious Games xAPI profile as part of the RAGE project.">
            <strong>Note: </strong>This vocabulary was designed for the Serious Games xAPI profile as part of the RAGE
            project. Recipes associated with this profile have been
            <a href="https://docs.google.com/spreadsheets/d/1o1qukRVI_eWpgnarh3n506HbzT1QTxerJ9eIfOfybZk/edit#gid=0" target="_blank">published
                here</a>. Terms that were not created by the Serious Games community, but are referenced from other
            vocabularies are higlighted in <span class="bg-warning"> <strong> yellow </strong> </span>.
        </div>
        <div property="dcterms:created" datatype="xsd:date" content="<?php echo $created; ?>">Date
            Created: <?php echo $created; ?></div>
        <div property="dcterms:modified" datatype="xsd:date" content="<?php echo $modified; ?>">Last
            Modified: <?php echo $modified; ?></div>
    </div>
    <br/>
    <?php
    echo_table($verbs, 'Verbs', 'Verb', 'info');
    echo_table($activities, 'Activity Types', 'Activity Type', 'danger');
    echo_table($extensions, 'Extensions', 'Extension', 'success');
    ?>

</div> <!-- .container-fluid -->
<!-- Bootstrap core JavaScript
    ================================================== -->
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->

</body>
</html>