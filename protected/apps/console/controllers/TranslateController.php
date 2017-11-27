<?php
/**
 * @category TranslateController
 * @author   gouki <gouki.xiao@gmail.com>
 * @created 2017/8/9 10:25
 * @since
 */

namespace console\controllers;

use yii\console\controllers\MessageController;
use yii\helpers\ArrayHelper;
use yii\helpers\Console;

class TranslateController extends MessageController
{
    /**
     * Extracts messages from a file
     * @param string $fileName name of the file to extract messages from
     * @param string $translator name of the function used to translate messages
     * @param array  $ignoreCategories message categories to ignore.
     * This parameter is available since version 2.0.4.
     * @return array
     */
    protected function extractMessages($fileName, $translator, $ignoreCategories = [])
    {
        $coloredFileName = Console::ansiFormat($fileName, [Console::FG_CYAN]);
        $this->stdout("Extracting messages from $coloredFileName...\n");
        $subject = file_get_contents($fileName);
        $messages = [];
        $tokens = token_get_all($subject);

        if(strpos($fileName, '.blade.php') !== false){
            preg_match_all('/\{\{(.*?)\}\}/si', $subject, $matches);
            $todoMatches = [];
            if(isset($matches[1]) && $matches[1]){
                $todoMatches = $matches[1];
            }
            preg_match_all('/\{!!.*?(Yii::t.*?\)).*?!!\}/si', $subject, $matches);
            if(isset($matches[1]) && $matches[1]){
                $todoMatches = ArrayHelper::merge($todoMatches, $matches[1]);
            }
            foreach($todoMatches as $match){
                $to = token_get_all('<?php ' . $match);
                array_shift($to);
                $tokens = array_merge_recursive($tokens, $to);
            }
        }
        foreach((array) $translator as $currentTranslator){
            $translatorTokens = token_get_all('<?php ' . $currentTranslator);
            array_shift($translatorTokens);
            $messages = array_merge_recursive($messages, $this->extractMessagesFromTokens($tokens, $translatorTokens, $ignoreCategories));
        }
        $this->stdout("\n");
        return $messages;
    }

    /**
     * Extracts messages from a parsed PHP tokens list.
     * @param array $tokens tokens to be processed.
     * @param array $translatorTokens translator tokens.
     * @param array $ignoreCategories message categories to ignore.
     * @return array messages.
     */
    private function extractMessagesFromTokens(array $tokens, array $translatorTokens, array $ignoreCategories)
    {
        $messages = [];
        $translatorTokensCount = count($translatorTokens);
        $matchedTokensCount = 0;
        $buffer = [];
        $pendingParenthesisCount = 0;

        foreach($tokens as $token){
            // finding out translator call
            if($matchedTokensCount < $translatorTokensCount){
                if($this->tokensEqual($token, $translatorTokens[$matchedTokensCount])){
                    $matchedTokensCount++;
                } else{
                    $matchedTokensCount = 0;
                }
            } elseif($matchedTokensCount === $translatorTokensCount){
                // translator found

                // end of function call
                if($this->tokensEqual(')', $token)){
                    $pendingParenthesisCount--;

                    if($pendingParenthesisCount === 0){
                        // end of translator call or end of something that we can't extract
                        if(isset($buffer[0][0], $buffer[1], $buffer[2][0]) && $buffer[0][0] === T_CONSTANT_ENCAPSED_STRING && $buffer[1] === ',' &&
                           $buffer[2][0] === T_CONSTANT_ENCAPSED_STRING){
                            // is valid call we can extract
                            $category = stripcslashes($buffer[0][1]);
                            $category = mb_substr($category, 1, -1);

                            if(!$this->isCategoryIgnored($category, $ignoreCategories)){
                                $message = stripcslashes($buffer[2][1]);
                                $message = mb_substr($message, 1, -1);

                                $messages[$category][] = $message;
                            }

                            $nestedTokens = array_slice($buffer, 3);
                            if(count($nestedTokens) > $translatorTokensCount){
                                // search for possible nested translator calls
                                $messages = array_merge_recursive($messages, $this->extractMessagesFromTokens($nestedTokens, $translatorTokens, $ignoreCategories));
                            }
                        } else{
                            // invalid call or dynamic call we can't extract
                            $line = Console::ansiFormat($this->getLine($buffer), [Console::FG_CYAN]);
                            $skipping = Console::ansiFormat('Skipping line', [Console::FG_YELLOW]);
                            $this->stdout("$skipping $line. Make sure both category and message are static strings.\n");
                        }

                        // prepare for the next match
                        $matchedTokensCount = 0;
                        $pendingParenthesisCount = 0;
                        $buffer = [];
                    } else{
                        $buffer[] = $token;
                    }
                } elseif($this->tokensEqual('(', $token)){
                    // count beginning of function call, skipping translator beginning
                    if($pendingParenthesisCount > 0){
                        $buffer[] = $token;
                    }
                    $pendingParenthesisCount++;
                } elseif(isset($token[0]) && !in_array($token[0], [T_WHITESPACE, T_COMMENT])){
                    // ignore comments and whitespaces
                    $buffer[] = $token;
                }
            }
        }

        return $messages;
    }
}
