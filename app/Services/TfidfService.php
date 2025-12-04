<?php

namespace App\Services;

class TfidfService
{
    
    public function tokenize($text)
    {
        $text = strtolower(strip_tags($text));
        $text = preg_replace('/[^a-z0-9\s]/', ' ', $text);
        return array_values(array_filter(explode(' ', $text)));
    }

    
    public function termFrequency($tokens)
    {
        $tf = [];
        $count = count($tokens);

        foreach ($tokens as $word) {
            if (!isset($tf[$word])) {
                $tf[$word] = 0;
            }
            $tf[$word]++;
        }

        foreach ($tf as $word => $freq) {
            $tf[$word] = $freq / $count;
        }

        return $tf;
    }

    
    public function inverseDocumentFrequency($documents)
    {
        $idf = [];
        $N = count($documents);

        foreach ($documents as $tokens) {
            foreach (array_unique($tokens) as $word) {
                if (!isset($idf[$word])) {
                    $idf[$word] = 0;
                }
                $idf[$word]++;
            }
        }

        foreach ($idf as $word => $freq) {
            $idf[$word] = log($N / $freq);
        }

        return $idf;
    }

    
    public function compute($documents)
    {
        $tokenized = array_map(fn ($d) => $this->tokenize($d), $documents);
        $idfs = $this->inverseDocumentFrequency($tokenized);

        $tfidf = [];

        foreach ($tokenized as $i => $tokens) {
            $tfidf[$i] = [];
            $tf = $this->termFrequency($tokens);

            foreach ($tf as $word => $v) {
                $tfidf[$i][$word] = $v * ($idfs[$word] ?? 0);
            }
        }

        return $tfidf;
    }

   
    public function cosineSimilarity($vec1, $vec2)
    {
        $dot = $mag1 = $mag2 = 0;
        $words = array_unique(array_merge(array_keys($vec1), array_keys($vec2)));

        foreach ($words as $w) {
            $a = $vec1[$w] ?? 0;
            $b = $vec2[$w] ?? 0;

            $dot += $a * $b;
            $mag1 += $a * $a;
            $mag2 += $b * $b;
        }

        if ($mag1 == 0 || $mag2 == 0) return 0;

        return $dot / (sqrt($mag1) * sqrt($mag2));
    }
}
