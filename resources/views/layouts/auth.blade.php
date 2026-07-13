<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Air Social — Sign in</title>
    @vite('resources/css/app.css')
    @livewireStyles
    </head>
    <body class="bg-white font-sans text-gray-900 antialiased">
        <div class="min-h-screen lg:grid lg:grid-cols-2">
            <!-- Brand / marketing panel -->
            <aside class="relative hidden overflow-hidden bg-gradient-to-br from-brand to-brand-dark text-white lg:flex lg:flex-col">

                <!-- Decorative backdrop -->
                <div class="pointer-events-none absolute inset-0 opacity-[0.07]" style="background-image: radial-gradient(circle at 1px 1px, white 1px, transparent 0); background-size: 28px 28px;"></div>
                <div class="pointer-events-none absolute -right-24 -top-24 h-72 w-72 rounded-full bg-white/10 blur-3xl"></div>
                <div class="pointer-events-none absolute -bottom-32 -left-20 h-80 w-80 rounded-full bg-black/10 blur-3xl"></div>

                <div class="relative flex h-full flex-col justify-between gap-12 p-12 lg:p-16">

                    <!-- Brand -->
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('images/logo-white.png') }}" alt="Air Social" class="h-10 w-10 object-contain">
                        <div>
                            <div class="text-3xl font-extrabold tracking-tight leading-none">Air Social</div>
                            <p class="mt-1 text-lg font-medium text-white/80">Where your team works, together.</p>
                        </div>
                    </div>

                    <!-- Message + features in a glass card -->
                    <div class="max-w-md rounded-2xl border border-white/15 bg-white/10 p-8 shadow-xl backdrop-blur-md">
                        <h2 class="text-2xl font-bold leading-snug lg:text-3xl">
                            Connect your company, your departments, and your people. Then extend it with the tools each team actually needs.
                        </h2>

                        <ul class="mt-8 space-y-4 text-white/90">
                            <li class="flex items-start gap-3">
                                <span class="grid h-8 w-8 shrink-0 place-items-center rounded-full bg-white/20 text-sm">✓</span>
                                <span>One shared workspace for your whole company</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="grid h-8 w-8 shrink-0 place-items-center rounded-full bg-white/20 text-sm">✓</span>
                                <span>Role-based access, department by department</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="grid h-8 w-8 shrink-0 place-items-center rounded-full bg-white/20 text-sm">✓</span>
                                <span>Install the plugins your team needs, from attendance and payroll to HR and more</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Footer -->
                    <div class="flex items-center justify-between text-sm text-white/60">
                        <span>© {{ date('Y') }} Air Social</span>
                        <span class="flex items-center gap-2">
                            <span class="h-2 w-2 rounded-full bg-white/70"></span>
                            Trusted workspace for modern teams
                        </span>
                    </div>
                </div>
            </aside>

        <!-- Form panel -->
        <main class="flex min-h-screen items-center justify-center px-6 py-12 lg:min-h-0">
            <div class="w-full max-w-lg">
                {{ $slot }}
            </div>
        </main>
    </div>

    @livewireScripts

    <script>
        function resetPasswordForm(initialCodeError = false) {
            return {
                showPassword: false,
                showConfirm: false,
                otpError: false,
                initialCodeError: initialCodeError,
                cooldownInitial: {{ config('otp.resend_cooldown_seconds') }},
                cooldown: {{ config('otp.resend_cooldown_seconds') }},
                resendReady: false,
                timer: null,

                get password() { return this.$wire.password || ''; },
                get passwordConfirmation() { return this.$wire.password_confirmation || ''; },

                get strength() {
                    const p = this.password;
                    let s = 0;
                    if (p.length >= 8) s++;
                    if (/[A-Z]/.test(p)) s++;
                    if (/\d/.test(p)) s++;
                    if (/[^A-Za-z0-9]/.test(p)) s++;
                    return s;
                },
                get reqLength() { return this.password.length >= 8; },
                get reqUpper() { return /[A-Z]/.test(this.password); },
                get reqNumber() { return /\d/.test(this.password); },
                get reqSpecial() { return /[^A-Za-z0-9]/.test(this.password); },

                get strengthLabel() {
                    if (this.password.length === 0) return '';
                    if (this.strength <= 2) return 'Weak';
                    if (this.strength === 3) return 'Medium';
                    return 'Strong';
                },
                get strengthBarClass() {
                    if (this.strength <= 2) return 'bg-red-400';
                    if (this.strength === 3) return 'bg-amber-400';
                    return 'bg-green-500';
                },
                get strengthTextClass() {
                    if (this.strength <= 2) return 'text-red-500';
                    if (this.strength === 3) return 'text-amber-500';
                    return 'text-green-600';
                },
                get otpInvalid() {
                    return this.otpError || !!this.$wire.error || this.initialCodeError;
                },

                init() {
                    this.$watch('$wire.error', value => {
                        if (value) {
                            this.otpError = true;
                            setTimeout(() => this.otpError = false, 450);
                        }
                    });
                    this.startCooldown();
                },
                startCooldown() {
                    this.resendReady = false;
                    this.cooldown = this.cooldownInitial;
                    clearInterval(this.timer);
                    this.timer = setInterval(() => {
                        if (this.cooldown > 0) this.cooldown--;
                        if (this.cooldown <= 0) {
                            this.resendReady = true;
                            clearInterval(this.timer);
                        }
                    }, 1000);
                },
                formatTime(s) {
                    const m = String(Math.floor(s / 60)).padStart(2, '0');
                    const sec = String(s % 60).padStart(2, '0');
                    return m + ':' + sec;
                },
                onResend() {
                    this.$wire.resend();
                    this.startCooldown();
                },
            };
        }

        function otpInput() {
            return {
                focusBox(index) {
                    const box = this.$refs['box' + index];
                    if (box) box.focus();
                },
                filterDigit(event, index) {
                    const char = event.target.value.replace(/\D/g, '').slice(-1) || '';
                    event.target.value = char;
                    if (char) this.focusBox(index + 1);
                },
                onBackspace(event, index) {
                    if (! event.target.value) this.focusBox(index - 1);
                },
                onArrow(event, index) {
                    if (event.key === 'ArrowLeft') this.focusBox(index - 1);
                    if (event.key === 'ArrowRight') this.focusBox(index + 1);
                },
                onPaste(event, index) {
                    event.preventDefault();
                    const length = {{ config('otp.length') }};
                    const text = (event.clipboardData || window.clipboardData).getData('text')
                        .replace(/\D/g, '').slice(0, length - index);
                    if (! text) return;
                    const chars = text.split('');
                    chars.forEach((char, offset) => {
                        const i = index + offset;
                        this.$refs['box' + i].value = char;
                        this.$refs['box' + i].dispatchEvent(new Event('input', { bubbles: true }));
                    });
                    this.focusBox(Math.min(index + chars.length, length - 1));
                },
            };
        }
    </script>
</body>
</html>
