function restoreAllResources() {
    // Restore all images
    document.querySelectorAll('img').forEach(img => {
        const src = img.src;
        img.src = '';
        img.src = src + '?t=' + new Date().getTime(); // Append timestamp to bypass cache
    });

    // Reload all scripts
    document.querySelectorAll('script').forEach(script => {
        if (script.src) {
            const newScript = document.createElement('script');
            newScript.src = script.src + '?t=' + new Date().getTime();
            newScript.async = true;
            script.parentNode.replaceChild(newScript, script);
        }
    });

    // Reload CSS files
    document.querySelectorAll('link[rel="stylesheet"]').forEach(link => {
        const href = link.href;
        link.href = '';
        link.href = href + '?t=' + new Date().getTime();
    });
}

// Automatically refresh every 5 seconds
setInterval(restoreAllResources, 5000);
