function cooldown(btn)
{
    btn.disabled = true;
    setTimeout(function ()
    {
        btn.disabled = false;
    }, 1000);
}