<?php
require_once("./vendor/autoload.php");

use DateInterval;
use Four026\Phable\Grammar;
use Four026\Phable\Trace;

function respond($body)
{
    header("Content-Type: application/json", true, 200);
    echo json_encode($body);
}

    /**
     * Helpfully reminds visitors what AGILE stands for.
     */
    function agile()
    {
        $grammar = new Grammar("./grammars/agile_grammar.json");

        $a_trace = new Trace($grammar);
        $a = $a_trace->setStartSymbol('origin_a')->getText();

        $g_trace = new Trace($grammar);
        $g = $g_trace->setStartSymbol('origin_g')->getText();

        $i_trace = new Trace($grammar);
        $i = $i_trace->setStartSymbol('origin_i')->getText();

        $l_trace = new Trace($grammar);
        $l = $l_trace->setStartSymbol('origin_l')->getText();

        $e_trace = new Trace($grammar);
        $e = $e_trace->setStartSymbol('origin_e')->getText();

        respond(compact('a', 'g', 'i', 'l', 'e'));
    }

    /**
     * Fetches a completely authentic tweet from John Carmack's timeline.
     */
    function carmack()
    {
        $grammar = new Grammar("./grammars/carmack_grammar.json");
        $trace = new Trace($grammar);
        $carmack = $trace->getText();

        respond(compact('carmack'));
    }

    /**
     * Tries to verify that the visitor is the contact that the agency told them about.
     */
    function codephrase()
    {
        $grammar = new Grammar("./grammars/codephrase_grammar.json");
        $trace = new Trace($grammar);
        $codephrase = $trace->getText();

        respond(compact('codephrase'));
    }

    /**
     * Welcomes visitors to the king's court by their name and title.
     */
    function lords()
    {
        $grammar = new Grammar("./grammars/lord_name_grammar.json");
        $trace = new Trace($grammar);
        $lord = $trace->getText();

        respond(compact('lord'));
    }

    /**
     * Sends visitors on a quest for a different legendary artefact every time they visit.
     */
    function macguffin()
    {
        $grammar = new Grammar("./grammars/macguffin_grammar.json");
        $trace = new Trace($grammar);
        $macguffin = $trace->getText();

        respond(compact('macguffin'));
    }

    /**
     * Displays a pitch for what will definitely, positively be the next huge free-to-play game.
     */
    function theNextBigThing()
    {
        $grammar = new Grammar('./grammars/next_big_thing_grammar.json');

        $trace = new Trace($grammar);
        $game_name = $trace->setStartSymbol('title')->getText();

        $trace = new Trace($grammar);
        $subtitle = $trace->setStartSymbol('subtitle')->getText();

        $trace = new Trace($grammar);
        $description = $trace->setStartSymbol('description')->getText();

        $num_emotions = mt_rand(5, 7);
        $emotions = array();
        for ($i = 0; $i < $num_emotions; ++$i) {
            $trace = new Trace($grammar);
            $emotions[] = $trace->setStartSymbol('emotion_origin')->getText();
        }
        $emotions = array_unique($emotions);

        $trace = new Trace($grammar);
        $platforms = $trace->setStartSymbol('platforms')->getText();

        //Pick a random date between 4 and 52 weeks from now.
        $date = date_create()->add(new DateInterval('P'.mt_rand(4, 52).'W'));

        respond(
            compact('game_name', 'subtitle', 'description', 'emotions', 'platforms', 'date')
        );
    }



switch ($_ENV['REQUEST_URI']) {
    case "/agile":
        agile();
        break;
    case "/carmack":
        carmack();
        break; 
    case "/codephrase":
        codephrase();
        break;
    case "/lords":
        lords();
        break;
    case "/macguffin":
        macguffin();
        break;
    case "/next-big-thing":
        theNextBigThing();
        break;

    default:
        http_response_code(404);
        echo "Unknown phable: " . $_ENV['REQUEST_URI'];
        break;
}