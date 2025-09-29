<h2 class="<?= $big_title_styles ?>">Sign Up or Log In</h2>

<div class="px-2 lg:px-auto">
    <div class="max-w-md mx-auto mt-12 mb-6 bg-black border-2 border-[#458B41] shadow-lg p-6 font-mono text-green-300 auth">

        <!-- Tab switcher -->
        <div class="flex mb-6">
            <button id="signupTab" class="flex-1 py-2 border-b-2 border-green-400 bg-green-900 hover:bg-green-900 font-bold text-center">Signup</button>
            <button id="loginTab"  class="flex-1 py-2 border-b-2 border-green-400 bg-black text-green-200 font-bold text-center">Login</button>
        </div>

        <!-- Forms -->
        <form action="../public/index.php?action=login" method="POST" id="loginForm" class="space-y-8 hidden">
            <input name="email" type="email" placeholder="Email" class="w-full bg-black border border-[#458B41] p-2 focus:outline-none focus:ring-2 focus:ring-green-500" />
            <input name="password" type="password" placeholder="Password" class="w-full bg-black border border-[#458B41] p-2 focus:outline-none focus:ring-2 focus:ring-green-500" />

            <button type="submit" class="w-full bg-black border-2 border-[#458B41] py-2 uppercase hover:bg-green-900">Login</button>
        </form>

        <form action="../public/index.php?action=signup" method="POST" id="signupForm" class="space-y-8">
            <input name="email" autofocus="true" type="email" placeholder="Email" class="w-full bg-black border border-[#458B41] p-2 focus:outline-none focus:ring-2 focus:ring-green-500" />
            <input name="password" type="password" placeholder="Password" class="w-full bg-black border border-[#458B41] p-2 focus:outline-none focus:ring-2 focus:ring-green-500" />
            <input name="password-repeat" type="password" placeholder="Repeat Password" class="w-full bg-black border border-[#458B41] p-2 focus:outline-none focus:ring-2 focus:ring-green-500" />

            <button type="submit" class="w-full bg-black border-2 border-[#458B41] py-2 uppercase hover:bg-green-900">Signup</button>
        </form>
    </div>
</div>

    <!-- output errors -->
    <?php if (isset($_SESSION['auth_error'])): ?>
        <div class="max-w-md mx-auto bg-black border border-red-700 text-red-700 px-4 py-3 mt-6 font-mono" role="alert">
            <strong class="font-bold">Error: </strong>
            <span class="block sm:inline"><?php echo $_SESSION['auth_error']; ?></span>
        </div>
    <?php unset($_SESSION['auth_error']); ?>
    <?php endif; ?>