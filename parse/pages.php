<?php
set_time_limit(0);
include "simple_html_dom.php";
include "functions" . DIRECTORY_SEPARATOR . "fetch.php";
libxml_use_internal_errors(TRUE);
const DOMAIN = 'https://www.888poker.com';
$currentDir = __DIR__;

// Переходим на уровень выше
$parentDir = dirname($currentDir);

// Добавляем "site" к пути
$sourceSiteDir = $parentDir . DIRECTORY_SEPARATOR . 'site';

$readySiteFiles = $parentDir . DIRECTORY_SEPARATOR . 'ready';


$paths = [
    // "/",
    "/how-to-play-poker/",
    "/how-to-play-poker/strategy/",
    "/how-to-play-poker/rules/",
    "/poker-software/",
    "/platforms/",
    "/poker-software/limits-and-rake/",
    "/poker-games/",
    "/poker-games/texas-holdem/",
    "/poker-games/omaha/",
    "/poker-games/omaha-hi-lo/",
    "/poker-games/blast-game/",
    "/poker-games/snap/",
    "/poker-promotions/",
    "/poker-promotions/bonus/",
    "/poker-promotions/bonus/no-deposit-8/",
    "/poker-promotions/24-7-freerolls-festival/",
    "/poker-promotions/invite-a-friend/iaf/",
    "/888poker-club/",
    "/real-money-poker/deposit/",
    "/real-money-poker/",
    "/real-money-poker/deposit/",
    "/real-money-poker/cashout/",
    "/real-money-poker/deposit/payment-methods/",
    "/real-money-poker/deposit/limits/",
    "/real-money-poker/deposit/money-transfer/",
    "/poker-tournaments/",
    "/poker-tournaments/types/",
    "/poker-tournaments/types/multi-table-tournament/",
    "/poker-games/pko/",
    "/poker-tournaments/mystery-bounty/",
    "/888live-events/",
    "/the-team/",
    "/magazine/strategy",
    "/magazine/poker-world",
    "/magazine/888news",
    "/poker/poker-odds-calculator/",
    "/poker-promotions/bonus/",
    "/poker-promotions/card-strike/",
    "/888live-events/coventry-oct-2023/",
    "/poker-promotions/snowmen-festival/",
    "/poker-promotions/xl-autumn-series/",
    "/poker-promotions/rakeback-upto50/",
    "/poker-promotions/",
    "/magazine/poker-world/five-old-west-poker-players",
    "/magazine/poker-world/top-heroes-poker-history",
    "/magazine/expert-tips-online-live-poker",
    "/magazine/",
    "/poker-games/",
    "/real-money-poker/",
    "/desktop/free-poker/",
    "/magazine/poker-terms",
    "/poker-tournaments/",
    "/poker-games/texas-holdem/",
    "/the-team/",
    "/poker-games/texas-holdem/",
    "/poker-games/omaha/",
    "/poker-games/blast-game/",
    "/poker-games/snap/",
    "/poker-games/",
    "/how-to-play-poker/hands/",
    "/how-to-play-poker/rules/",
    "/magazine/poker-terms/hole-cards",
    "/magazine/poker-world/how-to-deal-poker",
    "/magazine/poker-world/how-become-poker-dealer",
    "/magazine/poker-terms/no-limit",
    "/magazine/strategy/poker-betting-your-complete-one-stop-guide",
    "/magazine/strategy/poker-etiquette-30-unwritten-rules-everyone-needs-follow",
    "/how-to-play-poker/strategy/",
    "/magazine/poker-terms",
    "/poker-games/omaha/",
    "/poker-games/omaha-hi-lo/",
    "/magazine/strategy/poker-variations",
    "/magazine/strategy/top-9-online-poker-tips-beginners",
    "/free-online-poker/",
    "/magazine/888news/set-your-next-private-home-game-888poker",
    "/magazine/poker-terms/heads-up",
    "/magazine/poker-terms/wrap-around-straight",
    "/how-to-play-poker/rules/",
    "/magazine/strategy/pre-flop-hand-strength",
    "/magazine/strategy/mastering-fundamentals-texas-holdem/more-aggression-more-profit",
    "/poker/poker-odds-calculator",
    "/magazine/strategy/all-in-poker",
    "/magazine/strategy/all-in-poker",
    "/poker/poker-books",
    "/magazine/",
    "/magazine/strategy/poker-postion-names",
    "/magazine/strategy/beginners-guide-gto-poker",
    "/magazine/poker-mental-strategy",
    "/magazine/strategy/how-to-become-a-poker-pro",
    "/how-to-play-poker/strategy/texas-holdem",
    "/how-to-play-poker/strategy/tournaments",
    "/how-to-play-poker/strategy/omaha",
    "/how-to-play-poker/strategy/omaha-hi-lo",
    "/how-to-play-poker/",
    "/how-to-play-poker/hands/",
    "/how-to-play-poker/rules/",
    "/how-to-play-poker/strategy/",
    "/poker-tournaments/types/free/",
    "/how-to-play-poker/strategy/tournaments/",
    "/how-to-play-poker/strategy/texas-holdem/",
    "/real-money-poker/paypal/",
    "/real-money-poker/deposit/limits/",
    "/real-money-poker/deposit/money-transfer/",
    "/real-money-poker/cashout/reversing/",
    "/poker-tournaments/types/turbo-poker/",
    "/poker-tournaments/types/satellite/",
    "/poker-tournaments/types/free/",
    "/how-to-play-poker/strategy/tournaments/",
    "/how-to-play-poker/strategy/texas-holdem/",
    "/real-money-poker/paypal/",
    "/real-money-poker/deposit/limits/",
    "/real-money-poker/deposit/money-transfer/",
    "/real-money-poker/cashout/reversing/",
    "/poker-tournaments/types/turbo-poker/",
    "/poker-tournaments/types/satellite/",
    "/poker-tournaments/types/free/",
    "/how-to-play-poker/strategy/tournaments/",
    "/how-to-play-poker/strategy/texas-holdem/",
    "/real-money-poker/paypal/",
    "/real-money-poker/deposit/limits/",
    "/real-money-poker/deposit/money-transfer/",
    "/real-money-poker/cashout/reversing/",
    "/poker-tournaments/types/turbo-poker/",
    "/poker-tournaments/types/satellite/",
    "/magazine/poker-terms/flop/",
    "/magazine/poker-terms/river/",
    "/magazine/strategy/poker-blinds-guide/",
    "/poker-games/texas-holdem/",
    "/poker-games/omaha/",
    "/poker-games/omaha-hi-lo/",
    "/magazine/strategy/razz-poker/",
    "/magazine/strategy/2-7-triple-draw/",
    "/magazine/strategy/badugi-poker/",
    "/magazine/strategy/why-you-should-be-playing-short-deck-poker/",
    "/magazine/poker-world/top-10-unique-poker-games/",
    "/how-to-play-poker/",
    "/how-to-play-poker/hands/",
    "/how-to-play-poker/rules/",
    "/how-to-play-poker/strategy/",
    "/real-money-poker/paypal/",
    "/real-money-poker/deposit/limits/",
    "/real-money-poker/deposit/money-transfer/",
    "/real-money-poker/cashout/reversing/",
    "/poker-tournaments/types/turbo-poker/",
    "/poker-tournaments/types/satellite/",
    "/poker-tournaments/types/free/",
    "/how-to-play-poker/strategy/tournaments/",
    "/how-to-play-poker/strategy/texas-holdem/",
    "/real-money-poker/paypal/",
    "/real-money-poker/deposit/limits/",
    "/real-money-poker/deposit/money-transfer/",
    "/real-money-poker/cashout/reversing/",
    "/poker-tournaments/types/turbo-poker/",
    "/poker-tournaments/types/satellite/",
    "/poker-tournaments/types/free/",
    "/how-to-play-poker/strategy/tournaments/",
    "/how-to-play-poker/strategy/texas-holdem/",
    "/real-money-poker/paypal/",
    "/real-money-poker/deposit/limits/",
    "/real-money-poker/deposit/money-transfer/",
    "/real-money-poker/cashout/reversing/",
    "/poker-tournaments/types/turbo-poker/",
    "/poker-tournaments/types/satellite/",
    "/poker-tournaments/types/free/",
    "/how-to-play-poker/strategy/tournaments/",
    "/how-to-play-poker/strategy/texas-holdem/",
    "/poker-software/how-to-join-a-table/",
    "/poker-software/how-to-install/",
    "/poker-software/how-to-register/",
    "/platforms/",
    "/mobile-poker/webapp/",
    "/mobile-poker/iphone/",
    "/poker-games/",
    "/poker-games/texas-holdem",
    "/poker-games/omaha-hi-lo",
    "/poker-games/blast-game/",
    "/poker-games/snap/",
    "/poker-games/snap",
    "/desktop/",
    "/mobile-poker/",
    "/official-poker-terminology/#Rake",
    "/official-poker-terminology/#Pot",
    "/poker-software/",
    "/poker-software/faq/",
    "/poker-software/house-rules/",
    "/poker-software/limits-and-rake/",
    "/poker-software/multi-hand-tips/",
    "/poker-software/multi-table-tournaments/",
    "/download-poker/",
    "/poker-software/quick-start/",
    "/poker-software/sit-and-go-tournaments/",
    "/poker-software/tournament-prize-pool-structure/",
    "/poker-software/updates/",
    "/poker-software/multi-flight-tournaments/",
    "/download-poker/",
    "/poker-games/texas-holdem/",
    "/how-to-play-poker/strategy/texas-holdem/",
    "/download-poker/",
    "/poker-games/omaha-hi-lo/",
    "/how-to-play-poker/strategy/omaha-hi-lo/",
    "/download-poker/",
    "/poker-games/omaha/",
    "/how-to-play-poker/strategy/omaha/",
    "/download-poker/",
    "/poker-games/snap/",
    "/download-poker/",
    "/poker-games/blast-game/",
    "/poker-games/texas-holdem",
    "/poker-games/omaha/",
    "/poker-games/omaha-hi-lo/",
    "/poker-games/blast-game/",
    "/poker-games/pko/",
    "/real-money-poker/",
    "/poker-tournaments",
    "/magazine/strategy/poker-variations",
    "/magazine/strategy/5-card-draw",
    "/magazine/strategy/horse-poker",
    "/magazine/strategy/razz-poker",
    "/magazine/strategy/2-7-triple-draw",
    "/magazine/strategy/5-card-omaha",
    "/magazine/strategy/badugi-poker",
    "/magazine/poker-world/intro-to-chinese-poker",
    "/magazine/strategy/why-you-should-be-playing-short-deck-poker",
    "/magazine/strategy/poker-postion-names",
    "/magazine/how-to-play-poker/hands",
    "/magazine/strategy/learn-to-play-7-card-stud-poker-games",
    "/magazine/strategy/poker-bluff/",
    "/how-to-play-poker/strategy/texas-holdem/",
    "/mobile-poker/",
    "/poker-promotions/bonus/",
    "/poker-promotions/bonus/",
    "/poker-games/",
    "/poker-games/blast-game/",
    "/poker-games/no-limit-and-pot-limit-games/",
    "/poker-games/omaha/",
    "/poker-games/omaha-hi-lo/",
    "/poker-games/pko/",
    "/poker-games/ring-games/",
    "/poker-games/snap/",
    "/poker-games/texas-holdem/",
    "/poker-games/texas-holdem",
    "/how-to-play-poker/hands",
    "/magazine/strategy/ultimate-guide-poker-showdown",
    "/official-omaha-hi/",
    "/poker-games/",
    "/poker-games/blast-game/",
    "/poker-games/no-limit-and-pot-limit-games/",
    "/poker-games/omaha/",
    "/poker-games/omaha-hi-lo/",
    "/poker-games/pko/",
    "/poker-games/ring-games/",
    "/poker-games/snap/",
    "/poker-games/texas-holdem/",
    "/poker-games/texas-holdem",
    "/magazine/strategy/are-split-pots-waste-your-time",
    "/how-to-play-poker/strategy/omaha-hi-lo",
    "/magazine/strategy/ultimate-guide-poker-showdown/",
    "/official-omaha-hi/",
    "/poker-games/",
    "/poker-games/blast-game/",
    "/poker-games/no-limit-and-pot-limit-games/",
    "/poker-games/omaha/",
    "/poker-games/omaha-hi-lo/",
    "/poker-games/pko/",
    "/poker-games/ring-games/",
    "/poker-games/snap/",
    "/poker-games/texas-holdem/",
    "/official-blast/",
    "/poker-games/",
    "/poker-games/blast-game/",
    "/poker-games/no-limit-and-pot-limit-games/",
    "/poker-games/omaha/",
    "/poker-games/omaha-hi-lo/",
    "/poker-games/pko/",
    "/poker-games/ring-games/",
    "/poker-games/snap/",
    "/poker-games/texas-holdem/",
    "/poker-games/",
    "/poker-games/blast-game/",
    "/poker-games/no-limit-and-pot-limit-games/",
    "/poker-games/omaha/",
    "/poker-games/omaha-hi-lo/",
    "/poker-games/pko/",
    "/poker-games/ring-games/",
    "/poker-games/snap/",
    "/poker-games/texas-holdem/",
    "/poker-promotions/stroke-of-luck-casino/",
    "/poker-promotions/xl-autumn-series/",
    "/poker-promotions/bonus/",
    "/poker-promotions/card-strike/",
    "/poker-promotions/mystery-bounty/",
    "/poker-promotions/snowmen-festival/",
    "/poker-promotions/stroke-of-luck-casino/",
    "/poker-promotions/xl-autumn-series/",
    "/poker-promotions/rakeback-upto50/",
    "/poker-promotions/gift-drops/",
    "/poker-promotions/bet-get/",
    "/poker-promotions/daily-deals/",
    "/poker-promotions/24-7-freerolls-festival/",
    "/poker-promotions/invite-a-friend/iaf/",
    "/poker-promotions/blast-leaderboards/",
    "/poker-promotions/play-with-friends/",
    "/poker-promotions/multiprize-wheel/",
    "/poker-promotions/early-bird-rakeback/",
    "/poker-tournaments/",
    "/poker-games/",
    "/real-money-poker/deposit/bonus-policy/",
    "/terms/welcome-bonus/",
    "/terms/poker-new-reg-bonus-8/",
    "/terms/24-7-freerolls-festival",
    "/terms/invite-a-friend/",
    "/888poker-club/",
    "/888poker-club/benefits/",
    "/888poker-club/level-structure/",
    "/888poker-club/user-guide/",
    "/888poker-club/faq/",
    "/888poker-club/benefits/#Tournaments",
    "/poker-games/",
    "/terms/888poker-club-tnc/",
    "/real-money-poker/deposit/",
    "/real-money-poker/deposit/mobile/",
    "/real-money-poker/deposit/payment-methods/",
    "/real-money-poker/",
    "/real-money-poker/cashout/",
    "/real-money-poker/deposit/",
    "/real-money-poker/paypal/",
    "/real-money-poker/deposit/",
    "/real-money-poker/paypal/",
    "/real-money-poker/deposit/payment-methods/",
    "/real-money-poker/cashout/",
    "/real-money-poker/cashout",
    "/poker-games/",
    "/security-and-privacy/complete-security/",
    "/real-money-poker/deposit/quick/",
    "/real-money-poker/deposit/quick",
    "/real-money-poker/deposit/",
    "/real-money-poker/deposit/mobile/",
    "/real-money-poker/deposit/payment-methods/",
    "/real-money-poker/",
    "/real-money-poker/cashout/",
    "/real-money-poker/deposit/",
    "/real-money-poker/paypal/",
    "/real-money-poker/cashout/policy/",
    "/real-money-poker/cashout/reversing/",
    "/real-money-poker/",
    "/real-money-poker/deposit/",
    "/real-money-poker/paypal/",
    "/real-money-poker/",
    "/real-money-poker/deposit/",
    "/real-money-poker/paypal/",
    "/real-money-poker/",
    "/real-money-poker/deposit/",
    "/real-money-poker/paypal/",
    "/poker-tournaments/types/free/",
    "/how-to-play-poker/strategy/tournaments/",
    "/how-to-play-poker/strategy/texas-holdem/",
    "/real-money-poker/paypal/",
    "/real-money-poker/deposit/limits/",
    "/real-money-poker/deposit/money-transfer/",
    "/real-money-poker/cashout/reversing/",
    "/poker-tournaments/types/turbo-poker/",
    "/poker-tournaments/types/satellite/",
    "/poker-tournaments/types/free/",
    "/how-to-play-poker/strategy/tournaments/",
    "/how-to-play-poker/strategy/texas-holdem/",
    "/real-money-poker/paypal/",
    "/real-money-poker/deposit/limits/",
    "/real-money-poker/deposit/money-transfer/",
    "/real-money-poker/cashout/reversing/",
    "/poker-tournaments/types/turbo-poker/",
    "/poker-tournaments/types/satellite/",
    "/poker-tournaments/types/free/",
    "/how-to-play-poker/strategy/tournaments/",
    "/how-to-play-poker/strategy/texas-holdem/",
    "/real-money-poker/paypal/",
    "/real-money-poker/deposit/limits/",
    "/real-money-poker/deposit/money-transfer/",
    "/real-money-poker/cashout/reversing/",
    "/poker-tournaments/types/turbo-poker/",
    "/poker-tournaments/types/satellite/",
    " /real-money-poker/cashout/verify/",
    "/real-money-poker/",
    "/real-money-poker/deposit/",
    "/real-money-poker/paypal/",
    "/how-to-play-poker/strategy/texas-holdem/",
    "/real-money-poker/paypal/",
    "/real-money-poker/deposit/limits/",
    "/real-money-poker/deposit/money-transfer/",
    "/real-money-poker/cashout/reversing/",
    "/poker-tournaments/types/turbo-poker/",
    "/poker-tournaments/types/satellite/",
    "/poker-tournaments/types/knockout/",
    "/poker-tournaments/types/deep-stacks/",
    "/how-to-play-poker/strategy/texas-holdem/",
    "/real-money-poker/paypal/",
    "/real-money-poker/deposit/limits/",
    "/real-money-poker/deposit/money-transfer/",
    "/real-money-poker/cashout/reversing/",
    "/poker-tournaments/types/turbo-poker/",
    "/poker-tournaments/types/satellite/",
    "/poker-tournaments/types/knockout/",
    "/poker-tournaments/types/deep-stacks/",
    "/how-to-play-poker/strategy/texas-holdem/",
    "/real-money-poker/paypal/",
    "/real-money-poker/deposit/limits/",
    "/real-money-poker/deposit/money-transfer/",
    "/real-money-poker/cashout/reversing/",
    "/poker-tournaments/types/turbo-poker/",
    "/poker-tournaments/types/satellite/",
    "/poker-tournaments/types/knockout/",
    "/poker-tournaments/types/deep-stacks/",
    "/terms/new-tournament-collection/",
    "/poker-tournaments/mystery-bounty/",
    "/poker-tournaments/types/knockout/",
    "/poker-tournaments/types/multi-table-tournament/",
    "/poker-tournaments/",
    "/magazine/strategy/poker-bankroll-management",
    "/magazine/strategy/poker-tournament/mtt-poker-tournament-strategy-10-step-guide",
    "/poker-tournaments/",
    "/poker-tournaments/types/knockout/",
    "/poker-tournaments/types/free/",
    "/poker-tournaments/types/freezeout/",
    "/poker-tournaments/types/turbo-poker/",
    "/poker-tournaments/types/satellite/",
    "/poker-tournaments/types/multi-table-tournament/",
    "/poker-tournaments/types/deep-stacks/",
    "/poker-tournaments/types/heads-up/",
    "/poker-tournaments/types/sit-and-go/",
    "/poker-games/",
    "/poker-games/blast-game/",
    "/poker-games/no-limit-and-pot-limit-games/",
    "/poker-games/omaha/",
    "/poker-games/omaha-hi-lo/",
    "/poker-games/pko/",
    "/poker-games/ring-games/",
    "/poker-games/snap/",
    "/poker-tournaments/",
    "/poker-tournaments/types/knockout/",
    "/poker-tournaments/types/multi-table-tournament/",
    "/poker-tournaments/types/",
    "/888live-events/coventry-oct-2023/",
    "/888live-events/victoria-casino-weekend-2022/",
    "/888live-events/live-london-festival-2022/",
    "/888live-events/live-london-weekend-feb-2023/",
    "/888live-events/barcelona-festival-2023/",
    "/888live-events/london-festival-2023/",
    "/888live-events/madrid-festival-january-2023/",
    "/888live-events/lucky8-2022/",
    "/888live-events/cnp-madrid-2022/",
    "/888live-events/battle-of-malta-2022/",
    "/888live-events/road-to-las-vegas-2022/",
    "/888live-events/bucharest-2022/",
    "/888live-events/barcelona-festival-2022/",
    "/888live-events/london-festival-2023-uk/",
    "/888live-events/bucharest-aug-2023/",
    "/888live-events/london-festival-2022/",
    "/888live-events/victoria-casino-weekend-2022/",
    "/888live-events/live-london-festival-2022/",
    "/888live-events/live-london-weekend-feb-2023/",
    "/888live-events/barcelona-festival-2023/",
    "/888live-events/london-festival-2023/",
    "/888live-events/madrid-festival-january-2023/",
    "/the-team/jack-maate/",
    "/the-team/caue-moura/",
    "/the-team/kara-scott/",
    "/the-team/vivian-saliba/",
    "/the-team/cavalito/",
    "/the-team/ian-simpson/",
    "/the-team/lucia-navarro/",
    "/the-team/stream-team/"
];
$paths = array_unique($paths);
$internalLinks = [];
$titles = [];
$descriptions = [];
$options = array(
    'http' => array(
        'method' => "GET",
        'header' => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.3\r\n",
    ),
);

$context = stream_context_create($options);
foreach ($paths as $path) {
    echo 'begin process ' . $path . PHP_EOL;
    // $fullPath = $sourceSiteDir . str_replace('/', '\\', $path) . "index.html";
    $fullPath = DOMAIN . $path;

    if (($raw = @file_get_contents($fullPath, false, $context)) === false) {
        $error = error_get_last();
        echo "HTTP request failed. Error was: " . $error['message'] . PHP_EOL;
        continue;
    }

    $page = getFullPage($raw);

    foreach ($page->find('title') as $e) {
        $titles[$path] = $e->innertext;
        echo $e->innertext . PHP_EOL;
    }

    foreach ($page->find('meta[name=description]') as $e) {
        $descriptions[$path] = $e->content;
        echo $e->content . PHP_EOL;
    }

    $contentNode = getContentNode($raw, '.root');

    if ($contentNode) {

        foreach ($contentNode->find('*') as $e) {

            if (isset($e->src)) {
                $src = $e->src;
                if ($src == "") {
                    continue;
                }
                if (str_starts_with($src, '/')) {

                    $src = DOMAIN . $src;
                }
                if ($e->srcset) {
                    $e->removeAttribute('srcset');
                }
                $newsrc = saveAsset($src);
                $e->src = $newsrc;
            }
        }


        // foreach ($contentNode->find('img') as $e) {
        //     $src = $e->src;
        //     echo 'finded img ' . $src . PHP_EOL;
        //     if ($src == "") {
        //         break;
        //     }
        //     if (str_starts_with($src, '//')) {

        //         $src = str_replace('//', 'https://', $src);
        //     }
        //     if (str_starts_with($src, '/')) {

        //         $src = DOMAIN . $src;
        //     }
        //     if ($e->srcset) {
        //         $e->removeAttribute('srcset');
        //     }
        //     $newsrc = saveImg($src);
        //     $e->src = $newsrc;

        // }

        foreach ($contentNode->find('source') as $s) {
            $s->outertext = '';
        }
        foreach ($contentNode->find('iframe') as $s) {
            $s->outertext = '';
        }

        foreach ($contentNode->find('div') as $d) {
            if (str_contains($d->style, "background-image:url('")) {
                echo 'finded image in style tag ' . $d->style . PHP_EOL;
                $src = explode("'", $d->style)[1];
                $newsrc = saveAsset($src);
                echo $newsrc . PHP_EOL;
                $d->style = "background-image:url('" . $newsrc . "')";
            }
        }
        foreach ($contentNode->find('a') as $link) {
            $internalLinks[] = $link->href;
        }
        $contentNode->save('yo.html');
        $rendered_html = file_get_contents('yo.html');
        $final_file_content = '<?php include_once ($_SERVER["DOCUMENT_ROOT"]."/header.php"); ?>' . $rendered_html . '<?php include_once ($_SERVER["DOCUMENT_ROOT"]."/footer.php"); ?>';


        $res_link = $readySiteFiles . str_replace('/', '\\', $path);
        echo $res_link . PHP_EOL;
        if (!is_dir($res_link)) {
            mkdir($res_link, 0777, true);
        }
        file_put_contents($res_link . 'index.php', $final_file_content);
    } else {
        continue;
    }
}
// file_put_contents('internal_links.json', json_encode($internalLinks, JSON_UNESCAPED_UNICODE));
// file_put_contents('titles.json', json_encode($titles, JSON_UNESCAPED_UNICODE));
// file_put_contents('descriptions.json', json_encode($descriptions, JSON_UNESCAPED_UNICODE));
