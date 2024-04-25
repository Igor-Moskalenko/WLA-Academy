<?php
/**
 * Template Name: Homework First
 */
get_header(); ?>


<div class="grid-container">
    <div class="grid-x grid-margin-x">
        <div class="cell">

            <div class="block-one" style="margin-bottom: 20px">
                <h4>Block 1</h4>
                <!--  Task1-->
                <p class="task-1">
                    <?php
                    function showPlus10($num) {
                        $result = $num + 10;
                        echo $result;
                    }

                    showPlus10(25);
                    ?>
                </p>

                <!--  Task2-->
                <p class="task-2">
                    <?php
                    function getPlus10($num) {
                        $result = $num + 10;
                        return $result;
                    }

                    $myResult = getPlus10(15);
                    echo $myResult;
                    ?>
                </p>

            </div>

            <div class="block-two" style="margin-bottom: 20px">
                <h4>Block 2</h4>
                <!--  Task3-->
                <p class="task-3">
                    <?php
                    function pythagoras($leg1, $leg2) {
                        $hypotenuse = sqrt($leg1 ** 2 + $leg2 ** 2);
                        return $hypotenuse;
                    }

                    $result = pythagoras(10, 10);
                    echo $result;
                    ?>
                </p>


                <!--  Task4-->
                <p class="task-4">
                    <?php
                    function fac($k) {
                        if ($k == 0 || $k == 1) {
                            return 1;
                        } else {
                            return $k * fac($k - 1);
                        }
                    }

                    echo "Factorial 5: " . fac(5);
                    ?>
                </p>

                <!--  Task5-->
                <p class="task-5">
                    <?php
                    function square($w, $l) {
                        $result = $w * $l;
                        return $result;
                    }

                    $area = square(5, 7);
                    echo "Прямоугольник длиной 7 и шириной 5 имеет площадь " . $area;
                    ?>

                </p>

            </div>

            <div class="block-three">
                <h4>Block 3</h4>
                <!--  Task6-->
                <p class="task-6">
                    <?php
                    function trimText($text, $num_words)
                    {
                        $words = explode(" ", $text);
                        return implode(" ", array_slice($words, 0, $num_words));
                    }

                    $text = "Lorem ipsum dolor sit amet, consectetur adipiscing elit.";
                    $trimmed_text = trimText($text, 5);
                    echo $trimmed_text;
                    ?>
                </p>

                <!--  Task7-->
                <p class="task-7">
                    <?php
                    function date_publ_post($datetime)
                    {
                        $time = strtotime($datetime);
                        $now = time();
                        $diff = $now - $time;

                        if ($diff < 86400) {
                            $hours = floor($diff / 3600);
                            return $hours . ' hour' . ($hours > 1 ? 's' : '') . ' ago';
                        } else {
                            $days = floor($diff / 86400);
                            return $days . ' day' . ($days > 1 ? 's' : '') . ' ago';
                        }
                    }

                    $post_date = "2024-04-23 15:30:00";
                    echo date_publ_post($post_date);
                    ?>
                </p>

                <!--  Task8-->
                <p class="task-8">
                    <?php
                    function reverseString($str)
                    {
                        if ($str === '' || strlen($str) === 1) {
                            return $str;
                        } else {
                            return substr($str, -1) . reverseString(substr($str, 0, -1));
                        }
                    }

                    $str = "12345";
                    $reversedString = reverseString($str);
                    echo $reversedString;
                    ?>
                </p>

            </div>

        </div>
    </div>
</div>

<?php get_footer(); ?>
