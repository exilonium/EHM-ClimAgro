# Performance Note

## ~exilonium

### Optimizing Video Backgrounds for Fast Mobile Loading

To guarantee video backgrounds load rapidly on mobile devices:

- **Using compressed formats such as vp9** - we can encode videos in WebM (VP9) with an MP4 (H.264/H.265) fallback. WebM offers significantly smaller file sizes without much compromising on quality.
- **Reducing resolution** - Mobile backgrounds dont't really need to exceed 720p (cause most stuff is blurred japanese vids anyway, jk don't cancel me lol).
- **Lazy-load videos** - Use the `preload=none`attribute in html or an intersection observer in to defer(lazy load) until the user enters the viewport.
- **Have a skeleton loading** - Just like youtube homepage just add a skeleton loading this makes the page and videos load faster (psychology) than they actually are.
- **Serve a poster image first** - Set a `poster` attribute on the `<video>` tag so a static image renders, while the video buffers.
- **Disable autoplay on slow connections** - Use of the Network Information API in the browser to detect 2G/3G connections and substitute a static image instead of the video.

- **Multiple quality files** - In case the network speed is still low and video needs to be played we can just switch to a lower resolution video. we can just use ffmpeg to transcode the vid to lower resolution.

---

### Leveraging a CDN for Global Reports with Minimal Latency

To serve stuff to a global audience efficiently:

- **Push assets to edge nodes** - Push static stuff like HTML, CSS, JS, fonts, and media to a CDN (e.g., Cloudflare, AWS CloudFront,etc). Requests are served from the nearest Point of Presence , cutting round-trip times dramatically. and we can deploy round-robin and weighted round robin to fix the load balancing
- **Set aggressive cache headers** - Use a good values for max-age and cache-control header for versioned static assets so edge nodes cache them indefinitely.
- **Enable Brotli/Gzip compression** - it can reduce the network load drastically as less data neeeds to be transferred, its usually enabled by default.
- **Use cache-busting via filename hashing** - Append a hash to filenames (e.g., `report.67690.js`) so updates only invalidate changed files without nuking everything.
- **Preload critical assets** - Add `<link rel="preload">` so the web-browser fetches important stuff in parallel.
