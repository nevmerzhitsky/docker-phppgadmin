<?php
global $testsuite_file, $test_static_dir;

/**
 * 1/ Create the unique index
 * 2/ Drop the index
 **/
$t = new TestBuilder($server['desc'],
    'Index tests',
    'Create/Drop an unique Index'
);

$t->login($admin_user, $admin_user_pass);

/** 1 **/
$t->addComment('1. Create the unique index');
$t->clickAndWait("link={$lang['strdatabases']}");
$t->clickAndWait("link={$testdb}");
$t->clickAndWait("link={$lang['strschemas']}");
$t->clickAndWait('link=public');
$t->clickAndWait("link={$lang['strtables']}");
$t->clickAndWait('link=student');
$t->clickAndWait("link={$lang['strindexes']}");
$t->clickAndWait("link={$lang['strcreateindex']}");
$t->type('formIndexName', 'name_unique');
$t->addSelection('TableColumnList', 'label=name');
$t->click('add');
$t->clickAndWait("//input[@value='{$lang['strcreate']}']");
$t->assertText("//p[@class='message']", $lang['strindexcreated']);

/** 2 **/
$t->addComment('2. Drop the index');
$t->clickAndWait("link={$lang['strindexes']}");
$t->clickAndWait("//tr/td[text()='name_unique']/../td/a[text()='Drop']");
$t->click('cascade');
$t->clickAndWait('drop');
$t->assertText("//p[@class='message']", $lang['strindexdropped']);

$t->logout();
$t->writeTests("{$test_static_dir}/{$server['desc']}/index.html", $testsuite_file);
unset($t);
?>