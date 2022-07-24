@extends('home.layouts.master')
@section('title')
    Privacy Policy
@endsection
@section('style')
    <style>
        p {
            color: rgb(119, 113, 113);
        }
    </style>
@endsection
@section('body')
    <div class="container py-5">
        <p class="fs-3 text-center text-dark">Privacy Policy</p>
        <p>Quiz Earn respects your privacy of information, and is committed to protecting it at all times. Our privacy
            policy explains the usage, sharing, and protection of your information.<br>This privacy policy is applicable
            to
            all our online and offline services made available by us. Terms not included in our Privacy Policy may be found
            by users in our Terms of Service.
            <br>
            By using our services, you adhere to all the terms mentioned in our Privacy
            Policy. Thus, we advise our users to review the following carefully, inaddition to our Terms of Service, which
            is also applicable to all our online and offline services. If you have any questions regarding our terms of
            service or privacy policy, feel free to contact us at <a class="text-bold"
                href="mailto:admin@quizlearn.noonedev.com">admin@quizlearn.noonedev.com</a>.
        </p>
        <p>
            <i class="fa-solid fa-arrow-right ms-1"></i><a href="#information"> Information Collected by Us</a>
        </p>
        <p>
            <i class="fa-solid fa-arrow-right ms-1"></i><a href="#usage"> Usage of Information Collected</a>
        </p>
        <p>
            <i class="fa-solid fa-arrow-right ms-1"></i><a href="#disclosure"> Disclosure of Your Information to Third
                Parties</a>
        </p>
        <p>
            <i class="fa-solid fa-arrow-right ms-1"></i><a href="#account"> Correction, Update, and Cancellation of Your
                Account</a>
        </p>
        <p>
            <i class="fa-solid fa-arrow-right ms-1"></i><a href="#emails"> Promotional Emails</a>
        </p>
        <p>
            <i class="fa-solid fa-arrow-right ms-1"></i><a href="#publicly"> Publicly Disclosed Information</a>
        </p>
        <p>
            <i class="fa-solid fa-arrow-right ms-1"></i><a href="#security"> Security of Your Personal Information</a>
        </p>
        <p>
            <i class="fa-solid fa-arrow-right ms-1"></i><a href="#age"> Age Restrictions</a>
        </p>
        <p>
            <i class="fa-solid fa-arrow-right ms-1"></i><a href="#how"> How Do We Handle Changes to Our Privacy
                Policy?</a>
        </p>
        <p>
            <i class="fa-solid fa-arrow-right ms-1"></i><a href="#additonal"> How Do We Additional Questions</a>
        </p>
        {{-- <i cl
            ass="fa-solid fa-arrow-right ms-1"> --}}
        <div id="information">
            <span class="fs-5">Information Collected by Us</span>
            <p>Certain personal information is required for users to register on Quiz Earn. We collect this information to
                provide you with the intention of making your personal experience better. The current required data fields
                for
                users upon registration include your name, password and email . Here’s a list of data fields that we collect
                from our users for their profile creation:
            </p>
            <span class="ps-1">
                <i class="fa-solid fa-arrow-right ms-1"></i> Name
            </span><br>
            <span class="ps-1">
                <i class="fa-solid fa-arrow-right ms-1"></i> Password
            </span><br>
            <span class="ps-1">
                <i class="fa-solid fa-arrow-right ms-1"></i> Email
            </span><br>
            <p class="pt-1">Upon the completion of registration, users have complete access over the information they wish
                to share on
                our platforms. You may edit and update your disclosed information through your User Profile. All the data
                collected by us is crucial for improving user experience. collected by us is crucial for improving user
                experience.Information Third Parties Provide About You.
                <br>
                We may, from time to time, supplement the information we collect about you through our web site or Mobile
                Application with outside records from third parties in order to enhance our ability to serve you, to tailor
                our content to you, and to offer you opportunities to purchase services that we believe may be of interest
                to you. We may combine the information we receive from those sources with information we collect through the
                Services. In those cases, we will apply this Privacy Policy to any Personal Information received, unless we
                have disclosed otherwise.

            </p>
        </div>
        <div id="usage">
            <span class="fs-5">Usage of Information Collected</span>
            <p>If you decide to purchase any of our package services, we will process your payment information and retain
                this securely for the prevention of fraud and for audit/tax purposes. When you purchase a package to a paid
                service or make a purchase directly from us rather than through a platform such as iOS or Android you
                provide us or our payment service provider with information, such as your debit or credit card number or
                other financial information.
            </p>
        </div>
        <div id="disclosure">
            <span class="fs-5">Disclosure of Your Information to Third Parties</span>
            <br>

            <span class="ps-1">
                <i class="fa-solid fa-arrow-right ms-1"></i> Disclosure by Law

            </span>

            <p class="ms-2">In some situations, we may disclose your information. This may be done to assist law
                enforcement, comply
                with legal requirements, or protect our own rights.</p>
            <span class="ps-1">
                <i class="fa-solid fa-arrow-right ms-1"></i> Aggregate Data

            </span>
            <br>
            <p class="ms-2">We share aggregate data with third parties. However, in doing so, identities of individual
                users remain
                unidentified</p>
            <span class="ps-1">
                <i class="fa-solid fa-arrow-right ms-1"></i> Service Providers

            </span>
            <br>
            <p class="ms-2">Companies working with Quiz Earn have access to your data for various services that include
                analyzing customer data, marketing assistance, monetary transactions, or third party verification. They
                strictly use this data for performing a specific task, keeping your data safe and secure.</p>
        </div>
        <div id="emails">
            <span class="fs-5">Promotional Emails</span>
            <p>We offer promotional emails to keep our users engaged to your platforms and stay updated with the latest
                features of the app. Users can opt-out of receiving promotional emails by choosing the discontinue option at
                the bottom of any of our promotional emails. Administrative and transaction-related emails are expectations
                and cannot be opted-out anytime.
            </p>
        </div>
        <div id="security">
            <span class="fs-5">Security of Your Personal Information</span>
            <p>Our third party service provider securely stores all your personal information within their databases with
                all available security practices that include encryption, firewalls, and SSL to maximise security of your
                valuable information. Even though all commercially reasonable security protocols are followed, and we
                continuously update our organizational security measures, we do not guarantee that your information will
                always remain secure. As a safety measure, you should always keep your password concealed from others.
            </p>
        </div>
        <div id="age">
            <span class="fs-5">Age Restrictions</span>
            <p>Users need to be 13 years or older to access our apps and services. We do not permit underage users on our
                platforms and all users are encouraged to report a suspected underage user through the reporting mechanism
                of our platform.
            </p>
        </div>
        <div id="how">
            <span class="fs-5">How Do We Handle Changes to Our Privacy Policy?</span>
            <p>Our privacy policy is subject to revision from time to time. Users can always find the latest version of the
                Privacy Policy on our website. We will notify users when there’s a change in the privacy policy through a
                notice on all our platforms or/and via email. Continuation of using our services binds all the users to the
                latest revised Privacy Policy.
            </p>
        </div>
        <div id="additonal">
            <span class="fs-5">Additional Questions</span>
            <p>We welcome and entertain all feedback, questions and complaints regarding our Privacy Policy. Feel free to
                contact us at: <a class="text-bold"
                    href="mailto:admin@quizlearn.noonedev.com">admin@quizlearn.noonedev.com</a>
            </p>
        </div>
    </div>
@endsection
