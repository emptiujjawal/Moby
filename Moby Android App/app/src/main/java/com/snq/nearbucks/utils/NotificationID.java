package com.snq.nearbucks.utils;

import java.util.concurrent.atomic.AtomicInteger;

/**
 * Created by rahul on 8/7/17.
 */

public class NotificationID {
    private final static AtomicInteger c = new AtomicInteger(0);
    public static int getID() {
        return c.incrementAndGet();
    }
}