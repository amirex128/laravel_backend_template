<?php //075f2ee5d9314eac29d66b1965eff54d
/** @noinspection all */

namespace Illuminate\Contracts\View {

    /**
     * @method static $this extends($view, $params = [])
     * @method static $this layout($view, $params = [])
     * @method static $this layoutData($data = [])
     * @method static $this section($section)
     * @method static $this slot($slot)
     */
    class View {}
}

namespace Illuminate\Database\Eloquent {

    /**
     * @method static $this onlyTrashed()
     * @method static int restore()
     * @method static $this withTrashed($withTrashed = true)
     * @method static $this withoutTrashed()
     */
    class Builder {}
}

namespace Illuminate\Http {

    /**
     * @method static bool hasValidRelativeSignature()
     * @method static bool hasValidSignature($absolute = true)
     * @method static bool hasValidSignatureWhileIgnoring($ignoreQuery = [], $absolute = true)
     * @method static array validate(array $rules, ...$params)
     * @method static array validateWithBag(string $errorBag, array $rules, ...$params)
     */
    class Request {}
}

namespace Illuminate\Testing {

    /**
     * @method static $this assertDontSeeLivewire($component)
     * @method static $this assertSeeLivewire($component)
     */
    class TestResponse {}

    /**
     * @method static $this assertDontSeeLivewire($component)
     * @method static $this assertSeeLivewire($component)
     */
    class TestView {}
}

namespace Illuminate\View {

    use Livewire\WireDirective;

    /**
     * @method static WireDirective wire($name)
     */
    class ComponentAttributeBag {}

    /**
     * @method static $this extends($view, $params = [])
     * @method static $this layout($view, $params = [])
     * @method static $this layoutData($data = [])
     * @method static $this section($section)
     * @method static $this slot($slot)
     */
    class View {}
}
