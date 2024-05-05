"use strict";

let canv, ctx; // canvas and context
let maxx, maxy; // canvas dimensions

let radius; // hexagons radius (and side length)
let grid; // array of hexagons
let nbx, nby; // grid size (in elements, not pixels)
let orgx, orgy;
let perx, pery, pergrid;
let speed = 1; // pixels / ms
let bg;
let relY = 0.5;

// to create a non linear (linear by ranges) relationship between mouse position and speed
const POSSPEED = [0, 0.05, 0.5, 0.8, 0.94, 0.95, 1.0];
const VALSPEED = [0, 0, 1, 5, 100, 1000, 1000];

let nbLines, trackWidth, relTrackWidth;
let lines;

// for animation
let messages;

// shortcuts for Math.
const mrandom = Math.random;
const mfloor = Math.floor;
const mround = Math.round;
const mceil = Math.ceil;
const mabs = Math.abs;
const mmin = Math.min;
const mmax = Math.max;

const mPI = Math.PI;
const mPIS2 = Math.PI / 2;
const mPIS3 = Math.PI / 3;
const m2PI = Math.PI * 2;
const m2PIS3 = (Math.PI * 2) / 3;
const msin = Math.sin;
const mcos = Math.cos;
const matan2 = Math.atan2;

const mhypot = Math.hypot;
const msqrt = Math.sqrt;

const rac3 = msqrt(3);
const rac3s2 = rac3 / 2;

//------------------------------------------------------------------------

function alea(mini, maxi) {
  // random number in given range

  if (typeof maxi == "undefined") return mini * mrandom(); // range 0..mini

  return mini + mrandom() * (maxi - mini); // range mini..maxi
}
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
function intAlea(mini, maxi) {
  // random integer in given range (mini..maxi - 1 or 0..mini - 1)
  //
  if (typeof maxi == "undefined") return mfloor(mini * mrandom()); // range 0..mini - 1
  return mini + mfloor(mrandom() * (maxi - mini)); // range mini .. maxi - 1
}

function lerp(p0, p1, alpha) {
  return {
    x: p0.x * (1 - alpha) + p1.x * alpha,
    y: p0.y * (1 - alpha) + p1.y * alpha
  };
}

//------------------------------------------------------------------------

class Hexagon {
  constructor(kx, ky) {
    this.kx = kx;
    this.ky = ky;
    //        this.rot = intAlea(6); // random orientation
    this.rot = pergrid[ky % pery][kx % perx];

    this.exits = [];
    this.arcType = [];
    for (let k = 0; k < 6; ++k) {
      let v = [5, null, 0, 2, null, 3][(k - this.rot + 6) % 6];
      if (v === null) this.exits[k] = null;
      else this.exits[k] = (v + this.rot) % 6;
      this.arcType[k] = ["s", null, "b", "s", null, "b"][
        (k - this.rot + 6) % 6
      ]; // small or big
    } // for k
  } // Hexagon.constructor

  // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

  size() {
    // coordinates of centre
    this.xc = orgx + this.kx * 1.5 * radius;
    this.yc = orgy + this.ky * radius * rac3;
    if (this.kx & 1) this.yc -= radius * rac3s2; // odd columns, centre is a bit higher

    this.vertices = new Array(6).fill(0).map((v, k) => ({
      x: this.xc + radius * mcos(((k - 2) * mPI) / 3),
      y: this.yc + radius * msin(((k - 2) * mPI) / 3)
    }));
    this.vertices[6] = this.vertices[0]; // makes things easier by avoiding many "% 6" in calculating other calculations

    this.middle = new Array(6)
      .fill(0)
      .map((p, k) => lerp(this.vertices[k], this.vertices[k + 1], 0.5));

    this.extCenters = new Array(6).fill(0).map((v, k) => ({
      x: this.xc + rac3 * radius * mcos(((k - 1) * mPI) / 3 - mPIS2),
      y: this.yc + rac3 * radius * msin(((k - 1) * mPI) / 3 - mPIS2)
    }));

    // initial angle
    this.a0 = (this.rot * mPI) / 3; // angle shift due to cell orientation
  } // Hexagon.prototype.size

  // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

  drawHexagon() {
    ctx.beginPath();
    this.vertices.forEach((p, k) => {
      if (k == 0) ctx.moveTo(p.x, p.y);
      else ctx.lineTo(p.x, p.y);
    });
    ctx.lineWidth = 0.5;
    ctx.strokeStyle = "#fff";
    ctx.stroke();
  } // Hexagon.prototype.drawHexagon

  // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

  getNeighbor(edge) {
    const kx = this.kx + [0, 1, 1, 0, -1, -1][edge];
    const ky =
      this.ky +
      [
        [-1, 0, 1, 1, 1, 0],
        [-1, -1, 0, 1, 0, -1]
      ][this.kx & 1][edge];
    if (kx < 0 || kx >= nbx || ky < 0 || ky >= nby) return false;
    return grid[ky][kx];
  }
  // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
  setNeighbors() {
    this.neighbors = [];
    for (let k = 0; k < 6; ++k) {
      this.neighbors[k] = this.getNeighbor(k);
    } // for k
  } // setNeighbors
} //class Hexagon

//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------

function createGrid() {
  let line;

  perx = intAlea(1, 6);
  pery = intAlea(1, 5);
  perx = nbx;
  pery = nby;

  pergrid = [];
  for (let ky = 0; ky < pery; ++ky) {
    pergrid[ky] = line = []; // new line
    for (let kx = 0; kx < perx; ++kx) {
      line[kx] = intAlea(3);
    } // for let kx
  } // for ky

  grid = [];
  for (let ky = 0; ky < nby; ++ky) {
    grid[ky] = line = []; // new line
    for (let kx = 0; kx < nbx; ++kx) {
      line[kx] = new Hexagon(kx, ky);
      line[kx].size();
    } // for let kx
  } // for ky
} // createGrid
//-----------------------------------------------------------------------------
function makeLines() {
  /* creates description of line - not actuals lines with actual coordinates, just the relation between consecutive arcs in successive cells.
   */
  grid.forEach((line) => line.forEach((cell) => (cell.lines = new Array(6))));

  let lines = [];
  // open lines first
  grid.forEach((row) =>
    row.forEach((cell) => {
      for (let edge = 0; edge < 6; ++edge) {
        if (cell.exits[edge] === null) continue; // no line to begin here
        let neigh = cell.neighbors[edge];
        if (!neigh || neigh.exits[(edge + 3) % 6] === null) {
          // check this is actually the start of a line
          lines.push(makeLine(cell, edge));
        } // if true start
      } // for edge
    })
  );
  // remaining lines (closed)
  // open lines first
  grid.forEach((row) =>
    row.forEach((cell) => {
      for (let edge = 0; edge < 6; ++edge) {
        if (cell.exits[edge] === null) continue; // no line to begin here
        if (cell.lines[edge]) continue; // already a line here;
        lines.push(makeLine(cell, edge));
      } // for edge
    })
  );

  return lines;
} // makeLines

//-----------------------------------------------------------------------------
function makeLine(cell, edge) {
  /* creates a line entering this cell by this edge. */

  const line = { hue: intAlea(360), sat: intAlea(50, 100), segments: [] };
  let rcell = cell,
    redge = edge; // running cell and edge
  let segment;
  do {
    segment = { cell: rcell, kentry: redge };
    rcell.lines[redge] = line;
    line.segments.push(segment);
    let opp = rcell.exits[redge];
    segment.kexit = opp;
    let ncell = rcell.neighbors[opp];
    if (ncell === false) break; // end of line - no cell beyond exit edge
    if (ncell.exits[(opp + 3) % 6] === null) break; // end of line - no line starting here in next cell
    rcell = ncell;
    redge = (opp + 3) % 6;
    if (rcell == cell && redge == edge) {
      // back to start
      line.closed = true; // end of closed line
      break;
    }
  } while (true);
  return line;
} // makeLine

//-----------------------------------------------------------------------------
function getLinePath(line, k) {
  const path = new Path2D();
  line.segments.forEach((segment) => {
    segment.arc.addPath(path, k);
  });
  if (line.closed) path.closePath();
  return path;
}
//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------
class Arc {
  constructor(c, radius, a0, a1, ccw) {
    if (!c) return this; // empty arcs allowed
    this.c = c;
    this.radius = radius; // this is the radius at the middle width of the arc - actual radius depends on k ("track" index)
    this.a0 = a0; // 1st angle
    this.a1 = a1;
    this.ccw = ccw;
    // evaluate length
    if (ccw) [a0, a1] = [a1, a0];
    let len = (a1 - a0) % m2PI;
    if (len < 0) len += m2PI;
    this.deltaAng = ccw ? -len : len;
    this.len = len * radius;
  }
  addPath(path) {
    /* paths are simply juxtaposed rather than connected into a single path, because Chrome (not FF)
        generates weird artifacts when connecting 2 arcs. Even though the line connecting the ends of two arcs are at
        a distance < 1e-10, the lineJoin is quite visible and may have any direction
        would probably be invisible with thin lines but ugly with thick ones
        */
    if (!this.radius) {
      this.addPathLin(path, this.pos0, this.pos1);
      return;
    }

    let np = new Path2D();
    np.arc(this.c.x, this.c.y, this.radius, this.a0, this.a1, this.ccw);
    path.addPath(np);
  }

  addPathPartial(path, headPos, tailPos) {
    if (!this.radius) {
      this.addPathLin(path, tailPos, headPos);
      return;
    }

    let a0 = this.a0,
      a1 = this.a1;

    let da0 = 0,
      da1 = 1;
    if (headPos < this.pos1) {
      da1 = (headPos - this.pos0) / (this.pos1 - this.pos0);
    }
    if (tailPos >= this.pos0) {
      da0 = (tailPos - this.pos0) / (this.pos1 - this.pos0);
    }
    if (da0 > da1) da0 = da1 - 0.001;
    a0 = da0 * this.deltaAng + this.a0;
    a1 = da1 * this.deltaAng + this.a0;
    const np = new Path2D();
    np.arc(this.c.x, this.c.y, this.radius, a0, a1, this.ccw);
    path.addPath(np);
  }
  addPathLin(path, begin, eend) {
    const a0 = mmin(1, mmax(0, (begin - this.pos0) / this.len));
    const a1 = mmin(1, mmax((eend - this.pos0) / this.len));
    const p0 = lerp(this.p0, this.p1, a0);
    const p1 = lerp(this.p0, this.p1, a1);
    const np = new Path2D();
    np.moveTo(p0.x, p0.y);
    np.lineTo(p1.x, p1.y);
    path.addPath(np);
  }

  reverse() {
    [this.a0, this.a1] = [this.a1, this.a0];
    this.ccw = !this.ccw;
    this.deltaAng = -this.deltaAng;
  }
} // class Arc
//-----------------------------------------------------------------------------
function reverseLine(line) {
  line.reverse = !line.reverse;
  line.segments.reverse().forEach((segment) => {
    [segment.kentry, segment.kexit] = [segment.kexit, segment.kentry];
    segment.arc.reverse();
  });
}

//-----------------------------------------------------------------------------
class MotionPath {
  constructor(line, k) {
    let newArc, newRadius, newAngle, arcLength, newCenter, newa0, newCcw;
    line.motionPath = line.motionPath || [];
    line.motionPath[k] = this;

    this.line = line;
    this.kLine = k;
    this.movingLength = alea(2, 6) * radius;

    /* creates set of arcs starting out of the display and ending at the beginning of the line
        of course, arc is created moving backwards, starting from line and ending out of the screen
        this set of arcs can be emtpty, for lines which already have parts out of the display area
        */
    // make copy of arcs of line, with appropriate radii(depending on k)
    this.arcs = line.segments.map((segment) => {
      let arc = new Arc();
      Object.assign(arc, segment.arc);
      // update radius and length
      const dr = ((nbLines - 1) / 2 - k) * trackWidth;
      arc.radius = segment.arc.radius + (segment.arc.ccw ? -dr : dr);
      //          path.arc(this.c.x, this.c.y, radius, this.a0, this.a1, this.ccw);
      // DO NOT update len, so that lines will grow at same angular speed - much nicer
      //          arc.len = segment.arc.len * arc.radius / segment.arc.radius;
      return arc;
    });
    this.lineLength = this.arcs.reduce((s, v) => s + v.len, 0); // length of final part

    // line color
    let nk = line.reverse ? nbLines - 1 - k : k;
    let alpha = nbLines == 1 ? 0.5 : nk / (nbLines - 1);
    this.color = `hsl(${line.hue} ${line.sat}% ${75 - 50 * alpha}%)`;

    let currArc = this.arcs[0];
    let px = currArc.c.x + currArc.radius * mcos(currArc.a0);
    let py = currArc.c.y + currArc.radius * msin(currArc.a0);
    // add arc with a relatively small direction change and reasonable length
    // (direction changes too close to zero lead to hudge radii, which we want to avoid)
    newAngle = alea(0.1, 2);
    arcLength = radius * alea(1, 3); // why not ?
    newRadius = arcLength / newAngle;
    newCcw = !intAlea(2);

    /* create a previous arc with random radius and angle, but ccw opposite to current arc */
    if (newCcw == currArc.ccw) {
      newCenter = {
        x: currArc.c.x + (currArc.radius - newRadius) * mcos(currArc.a0),
        y: currArc.c.y + (currArc.radius - newRadius) * msin(currArc.a0)
      };
      newa0 = (currArc.a0 + (newCcw ? 1 : -1) * newAngle) % m2PI;
      newArc = new Arc(newCenter, newRadius, newa0, currArc.a0, newCcw);
    } else {
      newCenter = {
        x: currArc.c.x + (currArc.radius + newRadius) * mcos(currArc.a0),
        y: currArc.c.y + (currArc.radius + newRadius) * msin(currArc.a0)
      };
      newa0 = (currArc.a0 + mPI + (newCcw ? 1 : -1) * newAngle) % m2PI;
      newArc = new Arc(
        newCenter,
        newRadius,
        newa0,
        (currArc.a0 + mPI) % m2PI,
        newCcw
      );
    }
    this.arcs.unshift(newArc);
    // now, add straight line coming from beyond the screen edge
    // point on line = start of newArc
    let p = {
      x: newCenter.x + newRadius * mcos(newa0),
      y: newCenter.y + newRadius * msin(newa0)
    };
    // direction = direction of arc end
    let dir = newa0 + (newCcw ? +mPIS2 : -mPIS2);
    let dx = mcos(dir);
    let dy = msin(dir);
    let lstr = 1; // minimal length for straight line
    let ex, ey;
    while (true) {
      ex = p.x + lstr * dx;
      ey = p.y + lstr * dy;
      if (ex > maxx + trackWidth + 2 || ex < -trackWidth - 2) break;
      if (ey > maxy + trackWidth + 2 || ey < -trackWidth - 2) break;
      lstr += 20;
    }
    this.arcs.unshift(
      Object.assign(new Arc(), { p0: { x: ex, y: ey }, p1: p, len: lstr })
    ); // oops! not really an arc

    // complete arcs descriptions with length, initial and final distance from MotionPath starting point

    let curr = 0;
    this.arcs.forEach((arc) => {
      arc.pos0 = curr;
      curr += arc.len;
      arc.pos1 = curr;
    });
    this.headEndPoint = this.arcs.at(-1).pos1;
    this.tailEndPoint = this.headEndPoint - this.lineLength;
  } // constructor

  start(time) {
    this.prevTime = time;
    this.vHeadPos = 0;
  }

  draw(time) {
    if (this.prevTime === undefined) return; // not running yet
    const dt = time - this.prevTime;
    this.prevTime = time;
    this.vHeadPos += dt * speed;
    this.headPos = mmax(0, this.vHeadPos - this.deltaStart);
    if (this.headPos > this.headEndPoint) {
      this.headPos = this.headEndPoint;
      this.doneHead = true;
    }

    let tailPos = mmax(0, this.vHeadPos - this.deltaStart - this.movingLength);
    if (tailPos > this.tailEndPoint) {
      tailPos = this.tailEndPoint;
      this.doneTail = true;
    }

    const kHead = this.arcs.findLastIndex((arc) => arc.pos0 <= this.headPos); // index of arc where head currently is
    const kTail = this.arcs.findIndex((arc) => arc.pos1 > tailPos); // index of arc where tail currently is

    let path = new Path2D();
    for (let k = kTail; k <= kHead; ++k) {
      if (k == kHead || k == kTail)
        this.arcs[k].addPathPartial(path, this.headPos, tailPos);
      else this.arcs[k].addPath(path);
    } // for k
    ctx.lineWidth = trackWidth - 1;
    ctx.strokeStyle = this.color;
    ctx.stroke(path);
  }
} // class MotionPath
//-----------------------------------------------------------------------------

let animate;

{
  // scope for animate

  let animState = 0;
  let mps = [];
  let currLines;
  let done;

  animate = function (tStamp) {
    let message;
    message = messages.shift();
    if (message && message.message == "reset") animState = 0;
    if (message && message.message == "click") animState = 0;
    window.requestAnimationFrame(animate);

    switch (animState) {
      case 0:
        if (startOver()) {
          ++animState;
        }
        break;

      case 1:
        mps = [];
        lines.forEach((line) => {
          if (intAlea(2)) reverseLine(line); // randomly reverse lines
          for (let k = 0; k < nbLines; ++k) mps.push(new MotionPath(line, k));
        });
        mps.forEach((mp) => mp.start(tStamp));
        lines.forEach((line) => {
          let lng = line.motionPath.reduce(
            (s, mp) => mmax(s, mp.arcs.at(-1).pos1),
            0
          );
          line.motionPath.forEach((mp) => {
            mp.deltaStart = lng - mp.arcs.at(-1).pos1;
          }); // record max length in every mp for same arrival time
        });
        done = []; // list of finished
        currLines = [];
        ++animState;

      case 2:
        animState++;

      case 3:
        if (speed == VALSPEED.at(-1)) {
          animState = 5;
          break;
        } // fulll throttle
        if (currLines.length == 0 && lines.length == 0) {
          animState = 99;
          break;
        }
        ctx.fillStyle = bg;
        ctx.fillRect(0, 0, maxx, maxy);
        if (currLines.length < 4 && lines.length > 0) {
          let currLine = lines.splice(intAlea(lines.length), 1)[0];
          currLine.motionPath.forEach((mp) => mp.start(tStamp));
          currLines.push(currLine);
        }
        done.forEach((line) =>
          line.motionPath.forEach((mp) => mp.draw(tStamp))
        );
        for (let k = currLines.length - 1; k >= 0; --k) {
          let alldone = true;
          currLines[k].motionPath.forEach((mp) => {
            mp.draw(tStamp);
            alldone &&= mp.doneTail && mp.doneHead;
          });
          if (alldone) {
            done.push(currLines[k]);
            currLines.splice(k, 1);
          }
        }
        break;

      case 5:
        ctx.fillStyle = bg;
        ctx.fillRect(0, 0, maxx, maxy);
        tStamp = 1e10; // simulate much time ellapsed
        done.forEach((line) =>
          line.motionPath.forEach((mp) => mp.draw(tStamp))
        );
        currLines.forEach((line) =>
          line.motionPath.forEach((mp) => mp.draw(tStamp))
        );
        lines.forEach((line) =>
          line.motionPath.forEach((mp) => mp.draw(tStamp))
        );
        animState = 99;
        break;
    } // switch
  }; // animate
} // scope for animate

//------------------------------------------------------------------------
//------------------------------------------------------------------------

function startOver() {
  // canvas dimensions

  maxx = window.innerWidth;
  maxy = window.innerHeight;

  canv.width = maxx;
  canv.height = maxy;
  ctx.lineJoin = "bevel";
  //ctx.lineCap = 'round';

  ctx.fillStyle = "#000";
  ctx.fillRect(0, 0, maxx, maxy);

  radius = msqrt(maxx * maxy) / (6 + 15 * relY);

  // all hexagons fully visible
  nbx = mfloor((maxx / radius - 0.5) / 1.5);
  nby = mfloor(maxy / radius / rac3 - 0.5);
  // all screen covered with hexagons
  nbx = mceil(maxx / radius / 1.5 + 1);
  nby = mceil(maxy / radius / rac3 + 0.5);

  if (nbx < 1 || nby < 1) return false; // nothing to draw

  orgx = (maxx - radius * (1.5 * nbx + 0.5)) / 2 + radius; // obvious, insn't it ?
  orgy = (maxy - radius * rac3 * (nby + 0.5)) / 2 + radius * rac3; // yet more obvious

  createGrid();

  grid.forEach((line) =>
    line.forEach((cell) => {
      cell.setNeighbors();
      //cell.drawHexagon()
      //        cell.drawArcs()
    })
  );
  lines = makeLines();

  nbLines = intAlea(4, 10);

  relTrackWidth = 1 / (nbLines + 0.5);
  trackWidth = (radius / 2) * relTrackWidth;

  let pth;
  ctx.lineWidth = trackWidth - 0.5;

  // create Arcs from data in segments
  lines.forEach((line) => {
    line.segments.forEach((segment) => {
      let cell = segment.cell;
      let edge = segment.kentry;
      if (cell.arcType[edge] == "s") {
        // small arc
        segment.arc = new Arc(
          cell.vertices[edge],
          ((nbLines + 1) / 2) * trackWidth,
          (edge * mPI) / 3,
          (edge + 2) * mPIS3,
          false
        );
      } else {
        // big arc
        segment.arc = new Arc(
          cell.extCenters[edge],
          ((nbLines + 1) / 2) * trackWidth + radius,
          edge * mPIS3,
          (edge + 1) * mPIS3,
          false
        );
      }
    });
  });

  let hue = intAlea(360);
  let sat = intAlea(50, 100);
  bg = ctx.createLinearGradient(0, maxy, maxx, 0);
  let lum0, lum1;
  if (intAlea(2)) {
    lum0 = 10;
    lum1 = 20;
  } else {
    lum0 = 85;
    lum1 = 95;
  }
  bg.addColorStop(0, `hsl(${hue} ${sat}% ${lum0}%)`);
  bg.addColorStop(1, `hsl(${hue} ${sat}% ${lum1}%)`);
  return true;
} // startOver

//------------------------------------------------------------------------
function mouseMove(event) {
  cursorPosition(event.clientX, event.clientY);
} // mouseMove
//------------------------------------------------------------------------
function touchMove(event) {
  if (event.touches.length == 1)
    cursorPosition(event.touches[0].clientX, event.touches[0].clientY);
} // touchMove

//------------------------------------------------------------------------
function touchStart(event) {
  if (event.touches.length == 1)
    cursorPosition(event.touches[0].clientX, event.touches[0].clientY);
} // touchStart
//------------------------------------------------------------------------
function touchEnd(event) {
  if (event.touches.length == 1)
    cursorPosition(event.touches[0].clientX, event.touches[0].clientY);
  // event.preventDefault();
} // touchEnd

//------------------------------------------------------------------------
function touchMove(event) {
  if (event.touches.length == 1)
    cursorPosition(event.touches[0].clientX, event.touches[0].clientY);
} // touchMove

//------------------------------------------------------------------------
function cursorPosition(x, y) {
  if (!Number.isFinite(maxx) || !Number.isFinite(maxy)) return;
  const relX = x / maxx;
  let k = POSSPEED.findIndex((v) => relX <= v);
  if (k == 0) speed = VALSPEED[0];
  else {
    let x0 = POSSPEED[k - 1],
      x1 = POSSPEED[k],
      y0 = VALSPEED[k - 1],
      y1 = VALSPEED[k];
    speed = y0 + ((y1 - y0) * (relX - x0)) / (x1 - x0);
  }
  relY = y / maxy;
} // mouseMove

//------------------------------------------------------------------------

function mouseClick(event) {
  messages.push({ message: "click" });
} // mouseClick

//------------------------------------------------------------------------
//------------------------------------------------------------------------
// beginning of execution

{
  canv = document.createElement("canvas");
  canv.style.position = "absolute";
  document.body.appendChild(canv);
  ctx = canv.getContext("2d");
  //      canv.setAttribute('title', 'click me');
} // création CANVAS

canv.addEventListener("click", mouseClick);
canv.addEventListener("mousemove", mouseMove);
canv.addEventListener("touchstart", touchStart);
canv.addEventListener("touchmove", touchMove);
canv.addEventListener("touchend", touchEnd);

messages = [{ message: "reset" }];
requestAnimationFrame(animate);
