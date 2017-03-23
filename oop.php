<?php

class Model
{
    private $_winner = '';
    public $empty_board = array(
        11 => '',
        12 => '',
        13 => '',
        21 => '',
        22 => '',
        23 => '',
        31 => '',
        32 => '',
        33 => '',
    );

    public function index($board)
    {
        return $this->empty_board;
    }

    private function _checkLine($board)
    {
        $result = false;
        $hline = array_chunk($board, 3);

        foreach ($hline as $key => $rows) {
            $count = array_count_values($rows);
            if ($count['x'] == 3) {
                $this->setWinner('x');
                $result = true;
            } elseif ($count['o'] == 3) {
                $this->setWinner('o');
                $result = true;
            }
        }

        return $result;
    }

    private function _checkColumn($board)
    {
        $result = false;
        $vline = array_column($board, 3);

        foreach ($vline as $key => $cols) {
            $count = array_count_values($cols);
            if ($count['x'] == 3) {
                $this->setWinner('x');
                $result = true;
            } elseif ($count['o'] == 3) {
                $this->setWinner('o');
                $result = true;
            }
        }

        return $result;
    }

    private function _checkDiagonal($board)
    {
        $result = false;
        $dline = array(
            0 => array(11 => $board[11], 22 => $board[22], 33 => $board[33]),
            1 => array(31 => $board[31], 22 => $board[22], 13 => $board[13]),
        );

        foreach ($dline as $key => $diag) {
            $count = array_count_values($diag);
            if ($count['x'] == 3) {
                $this->setWinner('x');
                $result = true;
            } elseif ($count['o'] == 3) {
                $this->setWinner('o');
                $result = true;
            }
        }

        return $result;
    }

    private function _setWinner($figure = null)
    {
        $this->winner = $figure;
    }

    public function getWinner()
    {
        if ($this->winner == 'x') {
            $this->winner = 'User 1 Won!';
        }
        if ($this->winner == 'o') {
            $this->winner = 'User 2 Won!';
        }
        return $this->winner;
    }

}
