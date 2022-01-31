<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Result</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <style>
        .pils {}

    </style>
</head>

<body>
    <table width="100%" style="margin-top: 1px">
        <tr>
            <th style="margin: 1px">
                <p
                    style="background-color: rgba(146, 101, 189, 0.4);border:1px solid rgba(146, 101, 189,1);border-radius:20px;text-align:center;">
                    <span style="color:rgb(41, 39, 39);">Total : {{ $result->total }}</span>
                </p>
            </th>
            <th style="margin: 1px">
                <p
                    style="background-color: rgba(146, 101, 189, 0.4);border:1px solid rgba(146, 101, 189,1);border-radius:20px;text-align:center;">
                    <span style="color:rgb(41, 39, 39);">Incorrect : {{ $result->incorrect }}</span>
                </p>
            </th>
            <th style="margin: 1px">
                <p
                    style="background-color: rgba(146, 101, 189, 0.4);border:1px solid rgba(146, 101, 189,1);border-radius:20px;text-align:center;">
                    <span style="color:rgb(41, 39, 39);">Correct : {{ $result->correct }}</span>
                </p>
            </th>
            <th style="margin: 1px">
                <p
                    style="background-color: rgba(146, 101, 189, 0.4);border:1px solid rgba(146, 101, 189,1);border-radius:20px;text-align:center;">
                    <span style="color:rgb(41, 39, 39);">NotAttempted :
                        {{ $result->notAttempted }}</span>
                </p>
            </th>

        </tr>
        @for ($i = 0; $i < count($result_json); $i++)

            <?php $question = App\Models\Question::find($result_json[$i]->id); ?>
            <tr>
                <td colspan="4">
                    <p style="margin-top: 25px;font-size:20px">Q{{ $i + 1 . '  ) ' . $question->title }}</p>
                </td>

            </tr>
            <tr>
                <td colspan="2">
                    <p style="margin-left: 25px; padding:4px; color:green;"><b>A ) {{ $question->option1 }}</b></p>
                </td>
                <td colspan="2">
                    <p class="text-primary" style="margin-left: 25px; padding:4px">B ) {{ $question->option2 }}</p>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <p class="text-primary" style="margin-left: 25px; padding:4px">C ) {{ $question->option3 }}</p>
                </td>
                <td colspan="2">
                    <p class="text-primary" style="margin-left: 25px; padding:4px">D ) {{ $question->option4 }}</p>
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    <p class="text-success" style="margin-left: 20px;padding:10px 0px"> <b>Your Answer is
                            {{ $result_json[$i]->answer }}</b></p>
                </td>
            </tr>
        @endfor
        <?php $question_not = App\Models\Question::whereNotIn('id', $result->questionsid())
            ->where('quiz_id', $quiz_id)
            ->get(); ?>

        @foreach ($question_not as $question)


            <tr>
                <td colspan="4">
                    <p style="margin-top: 25px;font-size:20px">Q{{ $i + 1 . '  ) ' . $question->title }}</p>
                </td>

            </tr>
            <tr>
                <td colspan="2">
                    <p style="margin-left: 25px; padding:4px; color:green;"><b>A ) {{ $question->option1 }}</b></p>
                </td>
                <td colspan="2">
                    <p class="text-primary" style="margin-left: 25px; padding:4px">B ) {{ $question->option2 }}</p>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <p class="text-primary" style="margin-left: 25px; padding:4px">C ) {{ $question->option3 }}</p>
                </td>
                <td colspan="2">
                    <p class="text-primary" style="margin-left: 25px; padding:4px">D ) {{ $question->option4 }}</p>
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    <p class="text-success" style="margin-left: 20px;padding:10px 0px"> <b>Not Answered</b></p>
                </td>
            </tr>
            <?php $i = $i + 1; ?>
        @endforeach
    </table>


</body>

</html>
