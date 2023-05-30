@include('cbt.cbtIncludes.header')
<?php $user = Auth::guard('student')->user() ?>

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">
        @if($candidateQuestions->count() == 0)
            @include('cbt.cbtIncludes.takeExam')
        @else
            @include('cbt.cbtIncludes.examination')
        @endif

       
@include('cbt.cbtIncludes.footer')