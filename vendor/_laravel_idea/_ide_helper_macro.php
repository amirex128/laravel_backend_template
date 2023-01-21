<?php //5d07fec5f211ed67aa90a97fe4db9744
/** @noinspection all */

namespace Illuminate\Contracts\View {

    /**
     * @method $this extends($view, $params = [])
     * @method $this layout($view, $params = [])
     * @method $this layoutData($data = [])
     * @method $this section($section)
     * @method $this slot($slot)
     */
    class View {}
}

namespace Illuminate\Database\Eloquent {

    /**
     * @method $this onlyTrashed()
     * @method int restore()
     * @method $this withTrashed($withTrashed = true)
     * @method $this withoutTrashed()
     */
    class Builder {}
}

namespace Illuminate\Http {

    /**
     * @method bool hasValidRelativeSignature()
     * @method bool hasValidSignature($absolute = true)
     * @method bool hasValidSignatureWhileIgnoring($ignoreQuery = [], $absolute = true)
     * @method array validate(array $rules, ...$params)
     * @method array validateWithBag(string $errorBag, array $rules, ...$params)
     */
    class Request {}
}

namespace Illuminate\Testing {

    /**
     * @method $this assertDontSeeLivewire($component)
     * @method $this assertSeeLivewire($component)
     */
    class TestResponse {}

    /**
     * @method $this assertDontSeeLivewire($component)
     * @method $this assertSeeLivewire($component)
     */
    class TestView {}
}

namespace Illuminate\View {

    use Livewire\WireDirective;

    /**
     * @method WireDirective wire($name)
     */
    class ComponentAttributeBag {}

    /**
     * @method $this extends($view, $params = [])
     * @method $this layout($view, $params = [])
     * @method $this layoutData($data = [])
     * @method $this section($section)
     * @method $this slot($slot)
     */
    class View {}
}
