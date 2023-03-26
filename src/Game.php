<?php

namespace App;

class Game
{
    /**
     * The number of frames in a game.
     */
    const FRAMES_PER_GAME = 10;

    /**
     * All rolls for the game.
     *
     * @var array
     */
    protected $rolls = [];

    /**
     * Roll the ball
     *
     * @param int $pins
     * @return void
     */
    public function roll(int $pins) {
        $this->rolls[] = $pins;
    }

    /**
     * Calculate the final score.
     *
     * @return int
     */
    public function score() {
        $score = 0;
        $roll = 0;

        foreach (range(1, self::FRAMES_PER_GAME) as $frame){
            if($this->isStrike($roll)) {
                $score += $this->pinCount($roll) + $this->strikeBonus($roll);

                $roll += 1;

                continue;
            }

            $score += $this->defaultFrameScore($roll);

            if($this->isSpare($roll)) {
                $score += $this->defaultFrameScore($roll) + $this->spareBonus($roll);
            }

            $roll += 2;
        }

        return $score;
    }

    /**
     * @param $roll
     * @return bool
     */
    public function isStrike($roll)
    {
        return $this->pinCount($roll) === 10;
    }

    /**
     * @param $roll
     * @return bool
     */
    public function isSpare($roll)
    {
        return $this->defaultFrameScore($roll) === 10;
    }

    /**
     * @param $roll
     * @return int
     */
    public function defaultFrameScore($roll)
    {
        return $this->pinCount($roll) + $this->pinCount($roll + 1);
    }

    private function strikeBonus(int $roll)
    {
        return $this->pinCount($roll + 1) + $this->pinCount($roll + 2);
    }

    /**
     * @param $roll
     * @return int
     */
    public function spareBonus($roll)
    {
        return $this->pinCount($roll + 2);
    }

    protected function pinCount(int $roll) {
        return $this->rolls[$roll];
    }
}